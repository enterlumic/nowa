from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import mysql.connector
from bs4 import BeautifulSoup

# URL del producto
url = 'https://articulo.mercadolibre.com.mx/MLM-1943878078-emblema-honda-rojo-para-volante-de-civic-2006-al-2011-8vagen-_JM#polycard_client=recommendations_home_navigation-trend-recommendations&reco_backend=machinalis-homes-univb&reco_client=home_navigation-trend-recommendations&reco_item_pos=5&reco_backend_type=function&reco_id=6761245e-ad7a-4691-b06d-9773e05a9931&c_id=/home/navigation-trend-recommendations/element&c_uid=4a4a5673-1195-4cfa-8b7c-4b522f5be235'

# Configurar Selenium para usar Chrome
options = webdriver.ChromeOptions()
options.add_argument('--headless')  # Opcional: ejecuta el navegador en modo headless
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

# Abrir la página del producto
driver.get(url)

# Esperar hasta que el título del producto esté presente
try:
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CLASS_NAME, 'ui-pdp-title'))
    )
except Exception as e:
    print(f"No se pudo encontrar el título: {e}")
    driver.quit()
    exit()

# Obtener el HTML de la página
page_source = driver.page_source

# Analizar el contenido de la página con BeautifulSoup
soup = BeautifulSoup(page_source, 'html.parser')

# Extraer todas las URLs de las imágenes de la clase pswp__img
imagenes = []
imgs = soup.find_all('img', {'class': 'pswp__img'})
for img in imgs:
    src = img.get('src')
    if src:
        imagenes.append(src)

# Almacenar todas las URLs de las imágenes en una sola variable
imagenes_urls = "\n".join(imagenes)

# Extraer el título
titulo_tag = soup.find('h1', {'class': 'ui-pdp-title'})
titulo = titulo_tag.text.strip() if titulo_tag else 'No encontrado'

# Extraer el precio
precio_tag = soup.find('span', {'class': 'andes-money-amount__fraction'})
precio = precio_tag.text.strip() if precio_tag else 'No encontrado'

# Extraer la descripción como HTML
descripcion_tag = soup.find('div', {'class': 'ui-pdp-description__content'})
descripcion = str(descripcion_tag) if descripcion_tag else 'No encontrado'

# Extraer la marca
marca_tag = soup.find('a', {'class': 'ui-pdp-brand__name'})
marca = marca_tag.text.strip() if marca_tag else 'No encontrado'

# Cerrar el navegador
driver.quit()

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
    INSERT INTO productos (fotos, titulo, descripcion, precio, target)
    VALUES (%s, %s, %s, %s, %s)
''', ( imagenes_urls, titulo, descripcion, precio, url))

# Confirmar los cambios y cerrar la conexión
conn.commit()
cursor.close()
conn.close()