import jQuery from "jquery";
import popup  from './libs/popup.js'
import '/node_modules/select2/dist/css/select2.css';
import select2 from 'select2';

// window.$ = $
window.$ = window.jQuery = jQuery;

document.addEventListener("DOMContentLoaded", () => {
  popup($).closeGeneral()
  select2()
})

window.openPopup = (id) => {
	popup($).openPopup(id)
}
window.closePopup = (id) => {
	popup($).openPopup(id)
}
