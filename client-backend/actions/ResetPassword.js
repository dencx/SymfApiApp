import { baseURL } from "../src/config.js";
import { email } from "../src/config.js";
import { password } from "../src/config.js";

export class ResetPassword {
  makeRequest() {
    let params = {
      email: email,
    };

    let config = {
      headers: {
        accept: "application/json",
        "Content-Type": "application/json",
      },
    };

    return axios
      .post(baseURL + "/api/users/reset-password", params, config)
      .then((response) => {
        return response.data;
      })
      .catch((error) => {});
  }

  resetPassword(userId, token) {
    let config = {
      headers: {
        Accept: "application/ld+json",
        "Content-Type": "application/merge-patch+json",
      },
    };

    axios
      .patch(
        baseURL +
          "/api/users/" +
          userId +
          "/change-password?password=" +
          password +
          "&token=" +
          token,
          
        {},
        config
      )
      .then((response) => {
        console.log(response);
        localStorage.removeItem("userIdChangesPassword");
      })
      .catch((error) => {});
  }
}
