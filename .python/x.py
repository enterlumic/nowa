import sys
from PyQt5.QtWidgets import QApplication, QWidget, QPushButton, QVBoxLayout, QLabel
from PyQt5.QtCore import Qt, QEvent

class MiVentana(QWidget):
    def __init__(self):
        super().__init__()
        self.inicializarUI()

    def inicializarUI(self):
        self.setWindowTitle('Mi Aplicación con Eventos del Teclado')
        self.setGeometry(100, 100, 300, 200)  # x, y, ancho, alto

        # Añadir un botón
        self.boton = QPushButton('Haz clic aquí', self)
        self.boton.setToolTip('Presiona para hacer algo')

        # Añadir una etiqueta de texto
        self.etiqueta = QLabel('¡Bienvenido a tu aplicación!', self)

        # Añadir un layout vertical y agregar los widgets
        layout = QVBoxLayout()
        layout.addWidget(self.etiqueta)
        layout.addWidget(self.boton)
        self.setLayout(layout)

        self.setFocus()

    def keyPressEvent(self, event):
        if event.key() == Qt.Key_Escape:
            self.close()  # Cierra la aplicación si se presiona la tecla Escape
        elif event.key() == Qt.Key_Space:
            self.etiqueta.setText("¡Tecla Espacio presionada!")  # Cambia el texto si se presiona la tecla Espacio
        else:
            super().keyPressEvent(event)

    def event(self, event):
        event_dict = {
            QEvent.KeyPress: "KeyPress",
            QEvent.KeyRelease: "KeyRelease",
            QEvent.MouseButtonPress: "MouseButtonPress",
            QEvent.MouseButtonRelease: "MouseButtonRelease",
            QEvent.MouseMove: "MouseMove",
            QEvent.Resize: "Resize",
            QEvent.FocusIn: "FocusIn",
            QEvent.FocusOut: "FocusOut",
            QEvent.Close: "Close"
            # Agrega otros eventos según necesidad
        }
        
        event_name = event_dict.get(event.type(), "Unknown Event")
        print(f"Evento: {event.type()} - {event_name}")
        return super().event(event)

def crear_ventana():
    app = QApplication(sys.argv)
    ventana = MiVentana()
    ventana.show()
    sys.exit(app.exec_())

if __name__ == '__main__':
    crear_ventana()
