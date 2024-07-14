import tkinter as tk
from tkinter import filedialog, messagebox, scrolledtext
import os

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

def find_files_and_directories_to_rename(path, oldword):
    affected_files = []
    for root, dirs, files in os.walk(path, topdown=True):
        dirs[:] = [d for d in dirs if d not in ['storage', 'vendor', '.git', 'bootstrap']]
        for name in dirs + files:
            if oldword in name:
                affected_files.append(os.path.join(root, name))
    return affected_files

def find_files_to_replace_content(path, oldword):
    affected_files = []
    excluded_extensions = {'.png', '.jpg', '.jpeg', '.gif', '.bmp'}
    for root, dirs, files in os.walk(path, topdown=True):
        dirs[:] = [d for d in dirs if d not in ['storage', 'vendor', '.git', 'bootstrap']]
        for name in files:
            if any(name.lower().endswith(ext) for ext in excluded_extensions):
                continue
            file_path = os.path.join(root, name)
            try:
                with open(file_path, 'r', encoding='utf-8') as file:
                    if oldword in file.read():
                        affected_files.append(file_path)
            except UnicodeDecodeError:
                print(f"Skipping file due to decode error: {file_path}")
    return affected_files

def confirm_and_process_files(path, oldword, newword):
    rename_list = find_files_and_directories_to_rename(path, oldword)
    replace_list = find_files_to_replace_content(path, oldword)

    confirm_window = tk.Toplevel()
    confirm_window.title("Confirm Changes")

    scroll_txt = scrolledtext.ScrolledText(confirm_window, width=100, height=20)
    scroll_txt.pack(padx=10, pady=10)
    scroll_txt.insert(tk.INSERT, "The following files/directories will be affected:\n\n")
    scroll_txt.insert(tk.INSERT, "\n".join(rename_list + replace_list))
    scroll_txt.configure(state='disabled')

    btn_frame = tk.Frame(confirm_window)
    btn_frame.pack(pady=10)
    tk.Button(btn_frame, text="Yes", command=lambda: proceed_with_changes(path, oldword, newword, rename_list, replace_list, confirm_window)).pack(side=tk.LEFT, padx=10)
    tk.Button(btn_frame, text="No", command=confirm_window.destroy).pack(side=tk.LEFT)

def proceed_with_changes(path, oldword, newword, rename_list, replace_list, window):
    rename_files_and_directories(path, oldword, newword, rename_list)
    replace_content_in_files(path, oldword, newword, replace_list)
    messagebox.showinfo("Success", "Files have been successfully updated.")
    window.destroy()

def process():
    path = path_entry.get()
    oldword = oldword_entry.get()
    newword = newword_entry.get()
    if not path or not oldword or not newword:
        messagebox.showerror("Error", "All fields are required")
        return
    confirm_and_process_files(path, oldword, newword)

def select_path():
    selected_path = filedialog.askdirectory()
    path_entry.delete(0, tk.END)
    path_entry.insert(0, selected_path)

root = tk.Tk()
root.title("Renombrar y Reemplazar")

tk.Label(root, text="Ruta del Proyecto:").grid(row=0, column=0, padx=10, pady=5)
path_entry = tk.Entry(root, width=50)
path_entry.grid(row=0, column=1, padx=10, pady=5)
path_entry.insert(0, "/var/www/html/nowa")
tk.Button(root, text="Seleccionar", command=select_path).grid(row=0, column=2, padx=10, pady=5)

tk.Label(root, text="Palabra Antigua:").grid(row=1, column=0, padx=10, pady=5)
oldword_entry = tk.Entry(root, width=50)
oldword_entry.grid(row=1, column=1, padx=10, pady=5)

tk.Label(root, text="Palabra Nueva:").grid(row=2, column=0, padx=10, pady=5)
newword_entry = tk.Entry(root, width=50)
newword_entry.grid(row=2, column=1, padx=10, pady=5)

tk.Button(root, text="Procesar", command=process).grid(row=3, column=1, pady=10)

root.mainloop()
