<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Neuralink</title>

    <!-- Add Bootstrap and jQuery for simplicity -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        /* Style for white background and clean look */
        body {
            background-color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
        }

        /* Navigation bar fixed at the top */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #343a40; /* Dark background for navigation */
            z-index: 1000;
            padding: 10px 0;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li button {
            background-color: #6c757d; /* Bootstrap Slate color */
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        nav ul li button:hover {
            background-color: #5a6268;
        }

        /* General section styling */
        section {
            min-height: 100vh; /* Full height for each section */
            padding: 60px 20px;
            text-align: center;
        }

        section h1 {
            color: red;
        }

        section h3 {
            color: #333;
            margin: 20px auto;
        }

        .img img {
            max-width: 50%;
            height: auto;
            margin: 20px 0;
        }

        /* Adjust section padding to account for the fixed navbar */
        .content-section {
            padding-top: 120px;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav>
    <ul>
        <li><button onclick="scrollToSection('veil')">VEIL</button></li>
        <li><button onclick="scrollToSection('elon')">Elon Musk</button></li>
        <li><button onclick="scrollToSection('neuralink')">Neuralink</button></li>
        <li><button onclick="scrollToSection('puce')">Puce</button></li>
        <li><button onclick="scrollToSection('implantation')">Implantation</button></li>
        <li><button onclick="scrollToSection('experience')">Experience</button></li>
    </ul>
</nav>

<!-- Content Sections -->
<section id="veil" class="content-section">
    <h1>Veil</h1>
    <h3>Neuralink est une start-up américaine neurotechnologique qui développe des implants cérébraux d'interfaces directes neuronales fondée par Elon Musk.</h3>
    <div class="img">
        <img src="neuralink.jpg" alt="Neuralink Image">
    </div>
</section>

<section id="elon" class="content-section">
    <h1>Elon Musk</h1>
    <h3>Elon Musk est un entrepreneur milliardaire. Il détient la société SpaceX, la société automobile Tesla, propriétaire de Twitter et pour finir la société Neuralink.</h3>
    <div class="img">
        <img src="elon.jpg" alt="Elon Musk">
    </div>
</section>

<section id="neuralink" class="content-section">
    <h1>Neuralink</h1>
    <h3>Neuralink est une start-up américaine neurotechnologique qui développe des implants cérébraux d'interfaces directes neuronales fondée par Elon Musk.</h3>
    <div class="img">
        <img src="neuralink.jpg" alt="Neuralink Image">
    </div>
</section>

<section id="puce" class="content-section">
    <h1>Puce Électronique</h1>
    <h3>Une taille réduite qui devrait permettre à la puce d'être implantée facilement. Cette petite puce vise à développer des composants électroniques pouvant être intégrés dans le cerveau.</h3>
    <div class="img">
        <img src="cerveau.jpg" alt="Puce électronique">
    </div>
</section>

<section id="implantation" class="content-section">
    <h1>Implantation</h1>
    <h3>La technologie Neuralink implique l'implantation d'une puce dans le cerveau humain pour permettre une communication directe entre le cerveau et les ordinateurs.</h3>
    <div class="img">
                <img src="implant.jpg" class="rounded mx-auto d-block" alt="...">
            </div>
</section>

<section id="experience" class="content-section">
    <h1>Expérience sur un Humain</h1>
    <h3>Neuralink a présenté la personne qui avait reçu l'implant Neuralink via une diffusion en direct sur X. Devenu tétraplégique après un accident, l'appareil n'est pas encore parfait.</h3>
    <div class="img">
        <img src="experience.jpg" alt="Experience sur un humain">
    </div>
</section>



</body>
</html>
