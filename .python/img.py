import warnings
from cryptography.utils import CryptographyDeprecationWarning

warnings.filterwarnings(action="ignore", category=CryptographyDeprecationWarning)

import tkinter as tk
from tkinter import filedialog, messagebox
from rembg import remove
from PIL import Image, ImageEnhance, ImageFilter

def select_image():
    file_path = filedialog.askopenfilename(filetypes=[("Image files", "*.jpg;*.jpeg;*.png")])
    if file_path:
        process_image(file_path)

def process_image(input_path):
    try:
        output_path = input_path.replace('.', '_no_bg.')
        if not output_path.endswith('.png'):
            output_path = output_path + '.png'
        
        input_image = Image.open(input_path)
        
        # Preprocesamiento de la imagen para mejorar la eliminación del fondo
        input_image = enhance_image(input_image)
        
        output_image = remove(input_image)
        output_image.save(output_path)
        messagebox.showinfo("Success", f"Background removed successfully!\nSaved as {output_path}")
    except Exception as e:
        messagebox.showerror("Error", str(e))

def enhance_image(image):
    # Mejora del contraste
    enhancer = ImageEnhance.Contrast(image)
    image = enhancer.enhance(2)  # Ajusta el factor según sea necesario

    # Aplicar un filtro de nitidez
    image = image.filter(ImageFilter.SHARPEN)
    
    # Redimensionar la imagen si es muy grande
    max_size = (1024, 1024)
    image.thumbnail(max_size, Image.LANCZOS)
    
    return image

root = tk.Tk()
root.title("Background Remover")

tk.Button(root, text="Select Image", command=select_image).pack(pady=20)

root.mainloop()
