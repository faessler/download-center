// ================== //
// AJAX LOAD FOLDERS
// ================== //
function showFolder(e, t) {
    var n = new XMLHttpRequest;
    n.onreadystatechange = function () {
        4 == this.readyState && 200 == this.status && (document.getElementById("list").innerHTML = this.responseText)
    }, t ? n.open("GET", "index.php?folderUrl=" + e + "&folderName=" + t, !0) : n.open("GET", "index.php?folderUrl=" + e, !0), n.send()
}