import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2/dist/sweetalert2.js'

window.Alpine = Alpine;
window.Swal = Swal;

window.deleteDialog = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-danger tw-mr-2",
      cancelButton: "btn btn-secondary"
    },
    title: 'Are you sure want to delete?',
    text: 'Do you want to continue',
    icon: 'error',
    // reverseButtons: true,
    showCancelButton: true,
    confirmButtonText: 'Confirm',
    cancelButtonText: 'Cancel',
    buttonsStyling: false
  });

Alpine.start();
