<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Sections</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { margin: 0; }
        .container {
            display: flex;
            height: 100vh;
        }
        .section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }
        .active {
            background-color: lightblue;
        }
        .inactive {
            background-color: lightgray;
            pointer-events: none;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="section1" class="section active">
            <span id="activate1">Activate Section 1</span>
        </div>
        <div id="section2" class="section inactive">
            <span id="activate2">Activate Section 2</span>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#activate1").click(function() {
                $("#section1").removeClass("inactive").addClass("active");
                $("#section2").removeClass("active").addClass("inactive");
            });
            
            $("#activate2").click(function() {
                $("#section2").removeClass("inactive").addClass("active");
                $("#section1").removeClass("active").addClass("inactive");
            });
        });
    </script>
</body>
</html>