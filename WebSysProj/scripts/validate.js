// password validation
let pass = document.getElementById("ipass")
let isEight = document.getElementById("isEight")
let hasNums = document.getElementById("hasNums")
let hasChars = document.getElementById("hasChars")
let confPass = document.getElementById("cpass")
let submit = document.getElementById("submit")

pass.addEventListener("input", function(e) {
	e.preventDefault()
	let val = pass.value
	let cpass = confPass.value
	isEight.style.color = (val.length < 8) ? "red" : "green"
	hasNums.style.color = (!/[0-9]/.test(val)) ? "red" : "green"
	hasChars.style.color = (!/[^a-z0-9]/.test(val)) ? "red" : "green"
})

let fname = document.getElementById("fname")
let sname = document.getElementById("sname")
let validName = document.getElementById("validName")
fname.addEventListener("input", function(e) {
  e.preventDefault()
  let val = fname.value
  validName.textContent = (!/^[A-Za-z\s]+$/.test(val)) ? "Name fields must not contain special characters" : ""
})
sname.addEventListener("input", function(e) {
  e.preventDefault()
  let val = sname.value
  validName.textContent = (!/^[A-Za-z\s]+$/.test(val)) ? "Name fields must not contain special characters" : ""
})

let usrIn = document.getElementById("usrnm");
let valNm = document.getElementById("validUsrnm")
usrIn.addEventListener("input", function(e) {
  e.preventDefault()
  let val = usrIn.value
  valNm.textContent = (!/^[A-Za-z0-9]{5,15}$/.test(val)) ? "Must be between 5 to 15 characters and no special characters" : ""
})

confPass.addEventListener("input", function(e) {
	e.preventDefault()
	let val = pass.value
	let cpass = confPass.value
  let fullname = fname.value + " " + sname.value
  let uname = usrIn.value
	const isValid = (val.length >= 8) && (/[0-9]/.test(val)) && (/[^a-z0-9]/.test(val))
	const isSame = val !== "" && cpass !== "" && val === cpass
  const validName = (/^[A-Za-z\s]+$/.test(fullname))
  const validusrn = (/^[A-Za-z0-9]{5,15}$/.test(uname)) 
	submit.disabled = !(isValid && isSame && validName && validusrn)
})