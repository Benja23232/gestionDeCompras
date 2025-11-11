# Gestión de Compras 🛒

Sistema colaborativo para registrar productos, asignar consumidores y calcular deudas entre los participantes.  
Permite registrar pagos y mantener actualizado el balance de cada integrante del sistema.

---

## 🚀 Características principales
- **Usuarios (`User`)**: cada participante tiene email, nombre, roles y saldo.  
- **Compras (`Compra`)**: registran fecha, comprador y lista de productos asociados.  
- **Productos (`Producto`)**: incluyen nombre, precio, descuento opcional y consumidores vinculados.  
- **Pagos (`Pago`)**: registran transferencias de dinero entre usuarios (pagador → receptor) con fecha y monto.  
- Cálculo automático de **deudas compartidas** según productos consumidos y pagos realizados.  
- Interfaz pensada para la colaboración y transparencia.

---

## 🛠️ Instalación

### 1. Clonar el repositorio
```bash


git clone https://github.com/Benja23232/gestionDeCompras.git


cd gestionDeCompras
