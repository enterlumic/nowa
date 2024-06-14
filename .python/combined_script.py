import tkinter as tk
from tkinter import ttk, messagebox, filedialog
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import mysql.connector
import time
import requests
from bs4 import BeautifulSoup
from tqdm import tqdm
import os
from PIL import Image
from datetime import datetime

default_download_folder = "/var/www/html/nowa/public/assets/images/promociones"

def run_script():
    url = url_entry.get()
    download_folder = folder_entry.get()
    if not url:
        messagebox.showerror("Error", "Por favor, ingrese la URL del producto.")
        return

    if not download_folder:
        messagebox.showerror("Error", "Por favor, seleccione una carpeta para descargar las imágenes.")
        return

    driver = None
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

        # Descargar y guardar imágenes redimensionadas
        imagenes_nombres = []
        target_size = (400, 400)  # Tamaño objetivo
        for i, img_url in enumerate(imagenes):
            img_data = requests.get(img_url).content
            timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
            img_name = f"imagen_{timestamp}_{i+1}.jpg"
            img_path = os.path.join(download_folder, img_name)
            with open(img_path, 'wb') as handler:
                handler.write(img_data)
            # Redimensionar la imagen
            img = Image.open(img_path)
            img = img.resize(target_size, Image.LANCZOS)
            img.save(img_path)
            imagenes_nombres.append(img_name)

        imagenes_nombres_str = "\n".join(imagenes_nombres)

        status_label.config(text="Extrayendo información de la página...")
        response = requests.get(url)
        soup = BeautifulSoup(response.text, 'html.parser')

        titulo_tag = soup.find('h1', {'class': 'ui-pdp-title'})
        titulo = titulo_tag.text.strip() if titulo_tag else 'No encontrado'

        precio_tag = soup.find('span', {'class': 'price-tag-fraction'})
        precio = precio_tag.text.strip() if precio_tag else 'No encontrado'

        descripcion_tag = soup.find('div', {'class': 'ui-pdp-description__content'})
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
        ''', (imagenes_nombres_str, titulo, descripcion, precio, url))
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
        if driver:
            driver.quit()
        progress['value'] = 0

def clear_url_entry():
    url_entry.delete(0, tk.END)

def select_folder():
    folder_selected = filedialog.askdirectory()
    if folder_selected:
        folder_entry.delete(0, tk.END)
        folder_entry.insert(0, folder_selected)
    else:
        folder_entry.delete(0, tk.END)
        folder_entry.insert(0, default_download_folder)

# Crear la ventana principal
root = tk.Tk()
root.title("Extractor de Información de Productos")
root.minsize(600, 200)

# Crear y colocar los widgets
url_label = ttk.Label(root, text="URL del Producto:")
url_label.grid(row=0, column=0, padx=10, pady=10)

url_entry = ttk.Entry(root, width=50)
url_entry.grid(row=0, column=1, padx=10, pady=10)

folder_label = ttk.Label(root, text="Carpeta de Descarga:")
folder_label.grid(row=1, column=0, padx=10, pady=10)

folder_entry = ttk.Entry(root, width=50)
folder_entry.grid(row=1, column=1, padx=10, pady=10)
folder_entry.insert(0, default_download_folder)

select_folder_button = ttk.Button(root, text="Seleccionar", command=select_folder)
select_folder_button.grid(row=1, column=2, padx=10, pady=10)

run_button = ttk.Button(root, text="Ejecutar", command=run_script)
run_button.grid(row=2, column=0, pady=10)

clear_button = ttk.Button(root, text="Limpiar", command=clear_url_entry)
clear_button.grid(row=2, column=1, pady=10)

progress = ttk.Progressbar(root, orient='horizontal', length=400, mode='determinate')
progress.grid(row=3, column=0, columnspan=3, pady=10)

status_label = ttk.Label(root, text="Estado: Esperando URL del producto.")
status_label.grid(row=4, column=0, columnspan=3, padx=10, pady=10)

close_button = ttk.Button(root, text="Cerrar", command=root.destroy)
close_button.grid(row=5, column=1, pady=10)

# Ejecutar la aplicación
root.mainloop()
