import { baseURL } from "./config.js";
import { show } from "./view.js";
import { pagination } from "./pagination.js";
import { router } from "./router.js";

export const getData = (event) => {
  axios
    .get(baseURL + router(event))
    .then(function (response) {
      var el = document.createElement("script");
      el.type = "application/ld+json";
      var jsonLd = {
        "@context": "http://schema.org",
        "@id": "/api/product",
        "@type": "hydra:Collection",
      };
      jsonLd["hydra:member"] = response.data["hydra:member"];
      el.text = JSON.stringify(jsonLd);
      document.querySelector("head").appendChild(el);
      console.log(el.text);
      // console.log(response.data);

      const searchButton = document.getElementById("search-button");
      const orderByName = document.getElementById("order-by-name");
      const filetrWithImages = document.getElementById(
        "filter-with-images-only"
      );

      searchButton.addEventListener("click", getData);
      orderByName.addEventListener("click", getData);
      filetrWithImages.addEventListener("click", getData);

      orderByName.style.display = "block";
      filetrWithImages.style.display = "block";

      if (typeof orderByName.order === "undefined") orderByName.order = "asc";
      else if (orderByName.order == "asc") orderByName.order = "desc";
      else orderByName.order = "asc";

      pagination(response.data);
      show(response.data["hydra:member"]);
      
    })
    .catch(function (error) {
      // handle error
      console.log(error);
    });
};
