// function addProduct() {
//   let price = document.getElementById("price").value;
//   let product = document.getElementById("product").value;
//   let name = document.getElementById("stuts").value;
//   let tableElement = document.getElementById("table");
//   let trElement = document.createElement("tr");
//   let tbodyElement = document.createElement("tbody");
//   let priceFeild = document.createElement("td");
//   let productFeild = document.createElement("td");
//   let nameFeild = document.createElement("td");
//   let stutsFiled = document.createElement("td");
//   let buttons = document.getElementById("btns");

//   productFeild.innerHTML = product;
//   priceFeild.innerHTML = price;
//   nameFeild.innerHTML = name;
//   stutsFiled.innerHTML = buttons;
//   trElement.appendChild(productFeild);
//   trElement.appendChild(priceFeild);
//   trElement.appendChild(nameFeild);
//   tbodyElement.appendChild(trElement);
//   tableElement.appendChild(tbodyElement);
// }

// let myBtn = document.querySelector(".btn");
// myBtn.addEventListener("click", function () {
//   var myTable = document.querySelector(".table > tbody");
//   var newTr = document.createElement("tr");
//   var price = document.getElementById("price").value;
//   var product = document.getElementById("product").value;
//   var componnet = document.getElementById("stuts").value;
//   myTable.appendChild(newTr);
//   for (let i = 0; i < 4; i++) {
//     var values = [
//       product,
//       price,
//       componnet,
//       `<button type="submit"class="btn btn-primary me-3">Edit</button><button type="submit"class="btn btn-danger">Delete</button>`,
//     ];
//     let newtd = document.createElement("td");
//     newTr.appendChild(newtd);
//     newtd.innerHTML = `${values[i]}`;
//   }
// });
