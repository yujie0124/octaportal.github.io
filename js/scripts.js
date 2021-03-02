function blink(id) {
    var target = document.getElementById(id);
    target.classList.add("blink");
    setTimeout(function() {
        target.classList.remove("blink");
    }, 1000);
}

function showAlertBox(item, post_id, courseID, comment_id) {
    var ans = window.confirm("Are you sure you want to delete this " + item + "?");
    if (ans) {
        switch (item) {
            case "post":
                location.href = "delete.php?post_id=" + post_id + "&courseID=" + courseID;
                break;

            case "comment":
                location.href = "delete.php?comment_id=" + comment_id + "&post_id=" + post_id;
                break;
        }
    }
}

function showPopUp(post_title, post_content) {
    document.getElementById("modify-post").style.display = "block";
    document.getElementById("name").value = post_title;
    document.getElementById("description").value = post_content;
}

function closePopUp() {
    document.getElementById("modify-post").style.display = "none";
}