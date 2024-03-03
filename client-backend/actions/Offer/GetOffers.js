import { baseURL } from "../../src/config.js";
import { Login } from "../Login.js";

export class GetOffers extends Login {
  constructor() {
    super("GetOffers");
  }
  GetOffers() {
    let userId = localStorage.getItem("user_id");
    if (userId == null) return;
    axios
      .get(baseURL + "/api/users/" + userId + "/offers")
      .then((response) => {
        // console.log(response.data["hydra:member"]);
        response.data["hydra:member"].forEach((offer) => {
          this.addOptionElement(offer.url, offer["@id"]);
        });
      })
      .catch((error) => {
        this.handle401Error();
      });
  }
  addOptionElement(text, value) {
    let option = document.createElement("option");
    option.text = text;
    option.value = value;
    let select = document.getElementById("delete-offer");
    select.appendChild(option);
  }
}
