import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2/dist/sweetalert2.js'

window.Alpine = Alpine;
window.Swal = Swal;

window.confirmDialog = Swal.mixin({
    icon: 'warning',
    customClass: {
      confirmButton: "btn btn-danger tw-mr-2",
      cancelButton: "btn btn-secondary"
    },
    showCancelButton: true,
    showConfirmButton: true,
    confirmButtonText: 'Confirm',
    cancelButtonText: 'Cancel',
    buttonsStyling: false
  });

Alpine.start();
