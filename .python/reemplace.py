import tkinter as tk
from tkinter import filedialog, messagebox
import os
from tkinter import filedialog, messagebox, simpledialog

def rename_files_and_directories(path, oldword, newword):
    for root, dirs, files in os.walk(path, topdown=True):
        # Excluir directorios específicos
        dirs[:] = [d for d in dirs if d not in ['storage', 'vendor', '.git']]
        for name in dirs:
            if oldword in name:
                new_name = name.replace(oldword, newword)
                os.rename(os.path.join(root, name), os.path.join(root, new_name))
        for name in files:
            if oldword in name:
                new_name = name.replace(oldword, newword)
                os.rename(os.path.join(root, name), os.path.join(root, new_name))

def replace_content_in_files(path, oldword, newword):
    for root, dirs, files in os.walk(path, topdown=True):
        # Excluir directorios específicos
        dirs[:] = [d for d in dirs if d not in ['storage', 'vendor', '.git']]
        for name in files:
            file_path = os.path.join(root, name)
            if os.path.isfile(file_path):
                with open(file_path, 'r', encoding='utf-8') as file:
                    content = file.read()
                if oldword in content:
                    new_content = content.replace(oldword, newword)
                    with open(file_path, 'w', encoding='utf-8') as file:
                        file.write(new_content)

def process():
    path = path_entry.get()
    oldword = oldword_entry.get()
    newword = newword_entry.get()

    if not path or not oldword or not newword:
        messagebox.showerror("Error", "Todos los campos son obligatorios")
        return

    # rename_files_and_directories(path, oldword, newword)
    replace_content_in_files(path, oldword, newword)
    messagebox.showinfo("Éxito", "Proceso completado")

def select_path():
    selected_path = filedialog.askdirectory()
    path_entry.delete(0, tk.END)
    path_entry.insert(0, selected_path)

def find_files_and_directories_to_rename(path, oldword):
    affected_files = []
    for root, dirs, files in os.walk(path, topdown=True):
        dirs[:] = [d for d in dirs if d not in ['storage', 'vendor', '.git']]
        for name in dirs + files:
            if oldword in name:
                affected_files.append(os.path.join(root, name))
    return affected_files

def find_files_to_replace_content(path, oldword):
    affected_files = []
    for root, dirs, files in os.walk(path, topdown=True):
        dirs[:] = [d for d in dirs if d not in ['storage', 'vendor', '.git']]
        for name in files:
            file_path = os.path.join(root, name)
            with open(file_path, 'r', encoding='utf-8') as file:
                if oldword in file.read():
                    affected_files.append(file_path)
    return affected_files

def confirm_and_process_files(path, oldword, newword):
    # Find files to rename and replace content
    rename_list = find_files_and_directories_to_rename(path, oldword)
    replace_list = find_files_to_replace_content(path, oldword)

    # Show confirmation dialog with list of affected files
    message = "The following files/directories will be affected:\n\n"
    message += "\n".join(rename_list + replace_list)
    message += "\n\nDo you want to proceed?"
    response = messagebox.askyesno("Confirm Changes", message)
    if response:
        rename_files_and_directories(path, oldword, newword, rename_list)
        replace_content_in_files(path, oldword, newword, replace_list)
        messagebox.showinfo("Success", "Files have been successfully updated.")

def rename_files_and_directories(path, oldword, newword, files):
    for file in files:
        new_name = file.replace(oldword, newword)
        os.rename(file, new_name)

def replace_content_in_files(path, oldword, newword, files):
    for file in files:
        with open(file, 'r+', encoding='utf-8') as f:
            content = f.read()
            f.seek(0)
            f.write(content.replace(oldword, newword))
            f.truncate()

def process():
    path = path_entry.get()
    oldword = oldword_entry.get()
    newword = newword_entry.get()
    if not path or not oldword or not newword:
        messagebox.showerror("Error", "All fields are required")
        return
    confirm_and_process_files(path, oldword, newword)

# Configuración de la interfaz gráfica
root = tk.Tk()
root.title("Renombrar y Reemplazar")

tk.Label(root, text="Ruta del Proyecto:").grid(row=0, column=0, padx=10, pady=5)
path_entry = tk.Entry(root, width=50)
path_entry.grid(row=0, column=1, padx=10, pady=5)
path_entry.insert(0, "/var/www/html/")  # Añadir ruta por defecto
tk.Button(root, text="Seleccionar", command=select_path).grid(row=0, column=2, padx=10, pady=5)

tk.Label(root, text="Palabra Antigua:").grid(row=1, column=0, padx=10, pady=5)
oldword_entry = tk.Entry(root, width=50)
oldword_entry.grid(row=1, column=1, padx=10, pady=5)

tk.Label(root, text="Palabra Nueva:").grid(row=2, column=0, padx=10, pady=5)
newword_entry = tk.Entry(root, width=50)
newword_entry.grid(row=2, column=1, padx=10, pady=5)

tk.Button(root, text="Procesar", command=process).grid(row=3, column=1, pady=10)

root.mainloop()
