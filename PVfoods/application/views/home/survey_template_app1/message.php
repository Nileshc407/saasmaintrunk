<!DOCTYPE html>
<html>
<head>
    <title>Survey</title>
</head>
<body>
    <div id="messageBox" class="hidden">
        <div class="messageBoxContent" style="background-color: lightgrey;">
            <span class="close" id="closeMessageBox">&times;</span>
            <p style="font-size: 35px;"><?php echo $Message; ?></p>
        </div>
    </div>
</body>
</html>
<script>
const messageBox = document.getElementById("messageBox");
const closeMessageBoxButton = document.getElementById("closeMessageBox");

closeMessageBoxButton.addEventListener("click", () => {
    messageBox.style.display = "none";
});
</script>
<style>
/* Styles for the message box */
.hidden {
    //display: none;
}

.messageBoxContent {
    border: 1px solid #ccc;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    width: 700px;
    position: fixed;
    top: 14%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}
</style>