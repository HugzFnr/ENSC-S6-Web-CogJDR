<html>
    <head>
        <style>
            .hidden {
                visibility: hidden;
            }
        </style>

        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    </head>

    <body>
        <input type="text" name="test" id="test" required>
        <button id="go">Click</button>

        <script>
            $("#go").click(function(e) {
                    e.preventDefault();
                    alert($("#test").val() == "");
                });
        </script>
    </body>
</html>
