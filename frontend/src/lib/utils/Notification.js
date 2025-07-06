import {Notyf} from "notyf";
import 'notyf/notyf.min.css'

const notification = new Notyf({
  duration: 300,
  position: "top-right",
});

export function showMesageNotification(data, tipo) {

  if(Array.isArray(data)) {
      if(tipo == 'danger' || tipo == 'warning') {
        notification.error(data.join('\n'));
      }else if(tipo == 'warning') {
        notification.error(data.join('\n'));
      }
  }
}
