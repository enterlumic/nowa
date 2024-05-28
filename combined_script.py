import tkinter as tk
from tkinter import ttk
from tkinter import messagebox
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import mysql.connector
import time
import requests
from bs4 import BeautifulSoup
from tqdm import tqdm

def run_script():
    url = url_entry.get()
    if not url:
        messagebox.showerror("Error", "Por favor, ingrese la URL del producto.")
        return

    try:
        status_label.config(text="Configurando Selenium...")
        options = webdriver.ChromeOptions()
        options.add_argument('--headless')
        driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

        status_label.config(text="Abriendo página del producto...")
        driver.get(url)
        for i in tqdm(range(10), desc="Cargando página"):
            time.sleep(1)
            progress['value'] = (i + 1) * 10
            root.update_idletasks()

        try:
            gallery_button = driver.find_element(By.CLASS_NAME, 'ui-pdp-gallery__figure__image')
            gallery_button.click()
            time.sleep(2)
        except Exception as e:
            messagebox.showwarning("Advertencia", f"No se pudo encontrar la galería de imágenes: {e}")

        imagenes = []
        imgs = driver.find_elements(By.CLASS_NAME, 'pswp__img')
        for img in imgs:
            src = img.get_attribute('src')
            if src:
                imagenes.append(src)

        driver.quit()
        imagenes_urls = "\n".join(imagenes)

        status_label.config(text="Extrayendo información de la página...")
        response = requests.get(url)
        soup = BeautifulSoup(response.text, 'html.parser')

        titulo_tag = soup.find('h1', {'class': 'ui-pdp-title'})
        titulo = titulo_tag.text.strip() if titulo_tag else 'No encontrado'

        precio_tag = soup.find('span', {'class': 'andes-money-amount__fraction'})
        precio = precio_tag.text.strip() if precio_tag else 'No encontrado'

        descripcion_tag = soup.find('p', {'class': 'ui-pdp-description__content'})
        descripcion = str(descripcion_tag) if descripcion_tag else 'No encontrado'

        status_label.config(text="Conectando a la base de datos...")
        conn = mysql.connector.connect(
            host='localhost',
            user='adminBD',
            password='F4I6^$BDC-aEonn9',
            database='nowa'
        )
        cursor = conn.cursor()
        cursor.execute('''
            INSERT INTO promociones (fotos, titulo, descripcion, precio, target)
            VALUES (%s, %s, %s, %s, %s)
        ''', (imagenes_urls, titulo, descripcion, precio, url))
        conn.commit()
        cursor.close()
        conn.close()
        messagebox.showinfo("Éxito", "Datos insertados correctamente.")
        status_label.config(text="Proceso completado.")
        progress['value'] = 100

    except mysql.connector.Error as err:
        messagebox.showerror("Error de Base de Datos", f"Error: {err}")
        status_label.config(text="Error de Base de Datos")
    except Exception as e:
        messagebox.showerror("Error", f"Ocurrió un error: {e}")
        status_label.config(text="Error durante el proceso")
    finally:
        progress['value'] = 0

# Crear la ventana principal
root = tk.Tk()
root.title("Extractor de Información de Productos")

# Crear y colocar los widgets
url_label = ttk.Label(root, text="URL del Producto:")
url_label.grid(row=0, column=0, padx=10, pady=10)

url_entry = ttk.Entry(root, width=50)
url_entry.grid(row=0, column=1, padx=10, pady=10)

run_button = ttk.Button(root, text="Ejecutar", command=run_script)
run_button.grid(row=1, column=0, columnspan=2, pady=10)

progress = ttk.Progressbar(root, orient='horizontal', length=400, mode='determinate')
progress.grid(row=2, column=0, columnspan=2, pady=10)

status_label = ttk.Label(root, text="Estado: Esperando URL del producto.")
status_label.grid(row=3, column=0, columnspan=2, padx=10, pady=10)

# Ejecutar la aplicación
root.mainloop()
