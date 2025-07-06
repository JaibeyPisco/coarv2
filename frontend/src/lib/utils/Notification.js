  import { Notyf } from "notyf";
  import 'notyf/notyf.min.css'

  const notification = new Notyf({
    duration: 3000,
    position: {
      x: 'right',
      y: 'top',
    },
    types: [
      {
        type: 'info',
        background: '#2196f3',
        icon: false
      },
      {
        type: 'warning',
        background: '#ff9800',
        icon: false
      }
    ]
  });


  /**
   * Muestra una notificación con estilo según el tipo.
   * @param {string|string[]} message - Mensaje o array de mensajes a mostrar.
   * @param {'success'|'error'|'warning'|'info'} type - Tipo de notificación.
   */

  export function showMessageNotification(message, type="success") {

    const content = Array.isArray(message)?
     `<ul style="margin:0; padding-left: 1.2em;">${message.map(item => `<li>${item}</li>`).join('')}</ul>`
      //message.join('<br/>')
     : message;

    switch (type) {
      case 'success':
        notification.success(content);
        break;
      case 'error':
      case 'danger': // Alias aceptado
        notification.error(content);
        break;
      case 'warning':
        notification.open({ type: 'warning', message: content });
        break;
      case 'info':
        notification.open({ type: 'info', message: content });
        break;
      default:
        notification.open({ type: 'info', message: content });
        break;
    }
    
  }
