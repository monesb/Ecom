<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            background-color: #028a0f;
            display: flex;
            justify-content: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        ul button {
            color: white;
            padding: 14px 20px;
            border: none;
            background-color: #028a0f;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        ul button:hover {
            background-color: #025e0a;
        }

        section {
            padding: 60px 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            scroll-margin-top: 80px;
        }

        .content {
            width: 80%;
            margin: 0 auto;
            max-width: 1200px;
        }

        h1 {
            color: #028a0f;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .rectangle {
            border: 2px solid #028a0f;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        
    </style>
</head>

<body>

    <!-- Navigation -->
    <ul>
        <button onclick="window.location.href = '#accueil';">ACCUEIL</button>
        <button onclick="window.location.href = '#parcours';">PARCOURS</button>
        <button onclick="window.location.href = '#projets';">PROJETS</button>
        <button onclick="window.location.href = '#stages';">STAGES</button>
        <button onclick="window.location.href = '#contact';">CONTACT</button>
    </ul>

    <!-- ACCUEIL Section -->
    <section id="accueil" class="section">
        <div class="content">
            <h1>Mon portfolio</h1>
            <p>Je m'appelle Mones Boubahri, j'ai 19 ans.</p>
            <p>Je suis actuellement en deuxième année de BTS SIO, option SLAM, à l'école Insta Paris.</p>
        </div>
    </section>

    <!-- PARCOURS Section -->
    <section id="parcours" class="section">
        <div class="content">
            <h1>Mon parcours</h1>
            <div class="rectangle">
                <h3>Brevet des collèges</h3>
                <p>College Didier Dauras, Le Bourget (2019/2020)</p>
            </div>
            <div class="rectangle">
                <h3>Bac général</h3>
                <p>Lycée Germain Tillion, Le Bourget</p>
                <p>Bac général spécialité : Mathématiques et Sciences Économiques et Sociales (2022/2023)</p>
            </div>
            <div class="rectangle">
                <h3>BTS Services aux organisations</h3>
                <p>Insta, Paris</p>
                <p>BTS SIO option: SLAM (2023/2025)</p>
            </div>
        </div>
    </section>

    <!-- PROJETS Section -->
    <section id="projets" class="section">
        <div class="content">
            <h1>Mes projets</h1>
            <div class="rectangle">
                <h3>Projet 1</h3>
                <p>Pour mes études, je souhaite finir ma 2ème année de BTS SIO et continuer en licence 3 informatique.</p>
            </div>
            <div class="rectangle">
                <h3>Projet 2</h3>
                <p>Je souhaite me spécialiser dans l'intelligence artificielle et poursuivre un master dans ce domaine.</p>
            </div>
        </div>
    </section>

    <!-- STAGES Section -->
    <section id="stages" class="section">
        <div class="content">
            <h1>Mes stages</h1>
            <div class="rectangle">
                <h3>Stage en Terminale</h3>
                <p>Ecole ESD, Paris (2 semaines)</p>
            </div>
            <div class="rectangle">
                <h3>Stage en Première Année de BTS</h3>
                <p>Entreprise : Insta, Montreuil (juin 2024 - juillet 2024)</p>
            </div>
            <div class="rectangle">
                <h3>Stage en Deuxième Année de BTS</h3>
                <p>Entreprise : CHEYSSOI, Paris (Novembre 2024 - Janvier 2025)</p>
            </div>
        </div>
    </section>

    <!-- CONTACT Section -->
<section id="contact" class="section">
    <div class="content">
        <h1>Contact</h1>
        <div class="rectangle">
            <p>Mon email : monesboubahri@gmail.com</p>
            <p>Ma localisation : Le Bourget 93350, France</p>
            <p>Mon LinkedIn : 
                <a href="https://www.linkedin.com/in/mones-boubahri-4293a728a" target="_blank">
                    www.linkedin.com/in/mones-boubahri-4293a728a
                </a>
            </p>
            <p>
                <a href="CV Mones Bouahri Développeur web.pdf" download 
                   style="color: white; padding: 10px 15px; text-decoration: none; 
                          background-color: #028a0f; border-radius: 5px; transition: background-color 0.3s ease;">
                    Télécharger mon CV
                </a>
            </p>
        </div>
    </div>
</section>


   <!-- Button to navigate to veille.php -->
<section style="text-align: center; padding: 40px;">
    <button onclick="window.location.href = 'veile.php';" 
            style="color: white; padding: 10px 15px; text-align: center; 
                   font-size: 16px; text-decoration: none; 
                   background-color: #028a0f; border: none; border-radius: 5px; 
                   cursor: pointer; transition: background-color 0.3s ease;">
        Visitez ma Veille Technologique
    </button>
</section>



</body>

</html>
