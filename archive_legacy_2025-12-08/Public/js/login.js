function validateForm() {
    var username = document.forms["login"]["name"].value;
    var password = document.forms["login"]["password"].value;
    if (username == "" || password == "") {
        alert("Both username and password must be filled out");
        return false;
    }
    return true;
}