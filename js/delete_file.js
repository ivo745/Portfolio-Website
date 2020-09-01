// add halt before requesting again
function deleteFile(filename) {
    var http = new XMLHttpRequest();
    http.open('GET', 'delete_file.php?name=' + filename);
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            removeElement(filename);
        }
    };
    http.send(null);
}

function removeElement(elementId) {
    // Removes an element from the document
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}