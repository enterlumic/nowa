from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import mysql.connector
import time
import requests
from bs4 import BeautifulSoup
import matplotlib.pyplot as plt
from tqdm import tqdm

# Solicitar al usuario que ingrese la URL del producto
url = input("Por favor, ingrese la URL del producto: ")

# Configurar Selenium para usar Chrome
options = webdriver.ChromeOptions()
options.add_argument('--headless')  # Opcional: ejecuta el navegador en modo headless
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

# Abrir la página del producto
driver.get(url)

# Espera con una barra de progreso
for i in tqdm(range(10), desc="Cargando página"):
    time.sleep(1)

# Interactuar con la página si es necesario (por ejemplo, hacer clic en la galería de imágenes)
try:
    # Encontrar y hacer clic en la galería de imágenes si es necesario
    gallery_button = driver.find_element(By.CLASS_NAME, 'ui-pdp-gallery__figure__image')
    gallery_button.click()
    time.sleep(2)  # Esperar a que la galería se cargue
except Exception as e:
    print(f"No se pudo encontrar la galería de imágenes: {e}")

# Extraer todas las URLs de las imágenes de la clase pswp__img
imagenes = []
imgs = driver.find_elements(By.CLASS_NAME, 'pswp__img')
for img in imgs:
    src = img.get_attribute('src')
    if src:
        imagenes.append(src)

# Cerrar el navegador
driver.quit()

# Almacenar todas las URLs de las imágenes en una sola variable
imagenes_urls = "\n".join(imagenes)

# Mostrar todas las URLs de las imágenes
print(imagenes_urls)

# Realizar la solicitud HTTP a la página
response = requests.get(url)
soup = BeautifulSoup(response.text, 'html.parser')

# Extraer el título
titulo_tag = soup.find('h1', {'class': 'ui-pdp-title'})
titulo = titulo_tag.text.strip() if titulo_tag else 'No encontrado'

# Extraer el precio
precio_tag = soup.find('span', {'class': 'andes-money-amount__fraction'})
precio = precio_tag.text.strip() if precio_tag else 'No encontrado'

# Extraer la descripción como HTML
descripcion_tag = soup.find('p', {'class': 'ui-pdp-description__content'})
descripcion = str(descripcion_tag) if descripcion_tag else 'No encontrado'

print("Titulo:", titulo)
print("Precio:", precio)
print("Descripcion:", descripcion)

# Conectar a la base de datos MariaDB
conn = mysql.connector.connect(
    host='localhost',
    user='adminBD',
    password='F4I6^$BDC-aEonn9',
    database='nowa'
)
cursor = conn.cursor()

# Insertar los datos en la tabla
cursor.execute('''
    INSERT INTO promociones (fotos, titulo, descripcion, precio, target)
    VALUES (%s, %s, %s, %s, %s)
''', (imagenes_urls, titulo, descripcion, precio, url))

# Confirmar los cambios y cerrar la conexión
conn.commit()
cursor.close()
conn.close()
