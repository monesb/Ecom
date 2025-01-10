<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="portfolio.css">
    <title>Elon Musk</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-[hash]" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-[hash]" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://bootswatch.com/5/slate/bootstrap.min.css">
    
    <style>
        /* Style for the buttons */
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;  /* Align buttons in a row */
            justify-content: center; /* Center the buttons */
            position: fixed;  /* Fix buttons at the top */
            top: 0;
            width: 100%;
            background-color: #343a40;  /* Background color for the menu bar */
            padding: 10px 0;  /* Add some padding for spacing */
        }

        ul button {
            margin: 0 10px;  /* Space between buttons */
            background-color: #6c757d;  /* Bootstrap Slate color */
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        ul button:hover {
            background-color: #5a6268; /* Darker hover effect */
        }

        /* Push the content below the buttons */
        header {
            margin-top: 80px; /* Give space for the fixed menu */
        }
    </style>
</head>
<body>
    <!-- Button Section -->
    <ul>
        <button onclick="window.location.href = 'veil.php';">VEIL</button>
        <button onclick="window.location.href = 'Elon.php';">Elon Musk</button>
        <button onclick="window.location.href = 'neuralink.php';">Neuralink</button>
        <button onclick="window.location.href = 'puce.php';">PUCE</button>
        <button onclick="window.location.href = 'implatation.php';">IMPLANTATION</button>
        <button onclick="window.location.href = 'testN.php';">EXPERIENCE</button>
    </ul>

    <!-- Content Section -->
    <header>
        <h1><font color="red">Elon Musk</font></h1>
        <h3>Elon Musk est un entrepreneur milliardaire. Il détient la société SpaceX, la société automobile Tesla, propriétaire de Twitter et pour finir la société Neuralink.</h3>
        <div class="img">
            <img src="elon.jpg" class="rounded mx-auto d-block" alt="Elon Musk">
        </div>
    </header>
</body>
</html>
