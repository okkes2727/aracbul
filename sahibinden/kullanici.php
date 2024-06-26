<html>
<head>
<script>
function il(str) 
{
    if (str == "0")
    {
        document.getElementById("ilce").innerHTML = "";
        return;
    } 
    else 
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById("ilce").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ilce.php?q="+str,true);
        xmlhttp.send();
    }
}
function ilce(id) 
{
    if (id == "0") 
    {
        document.getElementById("mah").innerHTML = "";
        return;
    } 
    else 
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById("mah").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","mahalle.php?w="+id,true);
        xmlhttp.send();
    }
}
</script>
</head>
<body>
<form>
    <select name="users" onchange="il(this.value)">
        <option value="0">İl seçin:</option>
        <?php
        require 'ayar.php';
        $sql = "SELECT * FROM il";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value=".$row['il_id'].">".$row['il_adi']."</option>";
            }
        }
        mysqli_close($conn);
        ?>
    </select>
    <input type="hidden" id="selectedIlId" value="0"> <!-- Gizli alan -->
    <div id="ilce"></div>
    <div id="mah"></div>
</form>

<br>
</body>
</html>
