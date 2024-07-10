import tkinter as tk

def process_text():
    text = text_area.get("1.0", "end-1c")  # Obtiene el texto desde el inicio hasta el último caracter antes del nuevo espacio agregado al final
    lines = [line.strip() for line in text.splitlines() if line.strip()]  # Divide el texto en líneas y elimina espacios en blanco
    print("Lista de líneas ingresadas:")
    for line in lines:
        print(line)

# Configuración de la ventana
root = tk.Tk()
root.title("Caja de Texto para Listado")

# Configuración del área de texto
text_area = tk.Text(root, height=10, width=50)
text_area.pack(pady=20)

# Botón para procesar el texto
process_button = tk.Button(root, text="Procesar Texto", command=process_text)
process_button.pack()

# Ejecutar la ventana
root.mainloop()
