import axios from "axios";
import flasher from "@flasher/flasher"
const contactFormId = document.getElementById('checkBoxState')
console.log()
contactFormId.addEventListener('change',function () {
    console.log(this.checked)
    let contactFormId = this.getAttribute('data-idContactForm')
    axios.post('/contact/form/check', {check: this.checked, id: contactFormId})
        .then(function (response) {
            flasher.success("Formulaire de contact traité");
        })
        .catch(function (){
            flasher.error("Erreur, demande non traité");
        })
})