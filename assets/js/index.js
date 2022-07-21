
import { French } from "flatpickr/dist/l10n/fr.js"
const flatpickr = require("flatpickr");


document.querySelector("#date-picker").flatpickr({
  locale: French,
  mode: 'range',
  showMonths: 2,
  static:true,
});

document.querySelector('.flatpickr-calendar').style.right = '-4px';