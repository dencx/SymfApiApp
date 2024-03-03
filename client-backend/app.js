import { Register } from "./actions/Register.js";
import { Login } from "./actions/Login.js";
import { Products } from "./actions/Products.js";
import { AddOffer } from "./actions/Offer/AddOffer.js";
import { GetOffers } from "./actions/Offer/GetOffers.js";
import { DeleteOffer } from "./actions/Offer/DeleteOffer.js";
import { ResetPassword } from "./actions/ResetPassword.js";
import { Upload } from "./actions/Upload.js";

// Register.register();

window.onload = () => {
  let needsLogin = document.getElementById("needs-login");
  needsLogin.addEventListener("click", () => {
    let login = new Login();
    login.logout().then(() => login.login());
    needsLogin.style.display = "none";
  });
};

// offer
new Products();
let addOffer = document.getElementById("add-offer");
addOffer.addEventListener("click", () => {
  let url = document.getElementById("url");
  let price = document.getElementById("price");
  let currency = document.getElementById("currency");
  let product = document.getElementById("product");
  let product_id = product.options[product.selectedIndex].value;
  new AddOffer(url.value, parseFloat(price.value), currency.value, product_id);
});

new GetOffers();
let deleteOffer = document.getElementById("delete-offer-button");
deleteOffer.addEventListener("click", () => {
  let offer = document.getElementById("delete-offer");
  let offer_id = offer.options[offer.selectedIndex].value;
  new DeleteOffer(offer_id);
});

// password reset
let resetPasswordRequest = document.getElementById("reset-password-request");
resetPasswordRequest.addEventListener("click", () => {
  let resetP = new ResetPassword();
  resetP.makeRequest().then((response) => {
    if (typeof response !== "undefined") {
      localStorage.setItem("userIdChangesPassword", response);
      document.getElementById("reset-password-request").style.display = "none";
      document.getElementById("reset-password").style.display = "block";
    }
  });
});

let resetPassword = document.getElementById("reset-password");
resetPassword.addEventListener("click", () => {
  let resetP = new ResetPassword();
  // ... get somehow the token to validate the request ...
  let token = "af31775087293bbfe278674fd842c0d6fff4fb03";
  // ... then:
  resetP.resetPassword(localStorage.getItem("userIdChangesPassword"), token);
  document.getElementById("reset-password").style.display = "none";
});

if (localStorage.getItem("userIdChangesPassword") !== null) {
  document.getElementById("reset-password-request").style.display = "none";
  document.getElementById("reset-password").style.display = "block";
}

let upload = document.getElementById("upload-file");
upload.addEventListener("change", (e) => {
  let files = e.target.files || e.dataTransfer.files;
  if (!files.length) {
    console.log("no files");
  }
  let product = document.getElementById("product");
  let product_id = product.options[product.selectedIndex].value;
  if (product_id == "") return;
  // console.log(files[0].name);
  new Upload(files, product_id);
});
