
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn2");
        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function()
        {
            modal.style.display = "block";
            console.log("here");
        }
        span.onclick = function() 
        {
            modal.style.display = "none";
        }


