<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Países y Ciudades - Diseño Sofisticado</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a2a3a 0%, #0d1824 100%);
            color: #e0e0e0;
            min-height: 100vh;
            padding: 40px 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 50px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        h1 {
            font-size: 3.2rem;
            margin-bottom: 15px;
            background: linear-gradient(45deg, #ffd700, #ff8c00, #ff4500);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 2px 10px rgba(255, 215, 0, 0.3);
            letter-spacing: 1px;
        }

        .subtitle {
            font-size: 1.2rem;
            color: #a0a0a0;
            max-width: 600px;
            margin: 0 auto;
        }

        .pais-section {
            margin-bottom: 60px;
            position: relative;
        }

        .pais-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px 30px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .pais-header:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .pais-nombre {
            font-size: 2.2rem;
            font-weight: 700;
            margin-right: 20px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        .bandera-colores {
            display: flex;
            height: 30px;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
        }

        .color-bandera {
            flex: 1;
            height: 100%;
        }

        /* Colores de banderas */
        .es-color1 {
            background: #AA151B;
        }

        /* Rojo España */
        .es-color2 {
            background: #F1BF00;
        }

        /* Amarillo España */

        .de-color1 {
            background: #000000;
        }

        /* Negro Alemania */
        .de-color2 {
            background: #DD0000;
        }

        /* Rojo Alemania */
        .de-color3 {
            background: #FFCE00;
        }

        /* Amarillo Alemania */

        .at-color1 {
            background: #ED2939;
        }

        /* Rojo Austria */
        .at-color2 {
            background: #FFFFFF;
        }

        /* Blanco Austria */

        .pais-info {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .ciudades-count {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .tabla-container {
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease;
        }

        .tabla-container:hover {
            transform: scale(1.01);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1.1rem;
        }

        th {
            padding: 20px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        th:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
        }

        td {
            padding: 18px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background 0.3s ease;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Estilos específicos para cada país */
        .es-table th {
            background: linear-gradient(135deg, #AA151B 0%, #C11A22 100%);
            color: #F1BF00;
        }

        .es-table tr:nth-child(even) {
            background: rgba(170, 21, 27, 0.1);
        }

        .de-table th {
            background: linear-gradient(135deg, #000000 0%, #333333 50%, #DD0000 100%);
            color: #FFCE00;
        }

        .de-table tr:nth-child(even) {
            background: rgba(0, 0, 0, 0.1);
        }

        .at-table th {
            background: linear-gradient(135deg, #ED2939 0%, #F04A57 50%, #FFFFFF 100%);
            color: #ED2939;
        }

        .at-table tr:nth-child(even) {
            background: rgba(237, 41, 57, 0.1);
        }

        .ciudad-destacada {
            position: relative;
            font-weight: 600;
        }

        .ciudad-destacada:before {
            content: '★';
            margin-right: 8px;
            color: #ffd700;
        }

        .numero-dato {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            text-align: right;
        }

        .dato-label {
            display: inline-block;
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.85rem;
            margin-left: 10px;
        }

        footer {
            text-align: center;
            margin-top: 60px;
            padding: 30px;
            color: #888;
            font-size: 0.9rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 768px) {
            .pais-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .pais-info {
                margin-left: 0;
                margin-top: 15px;
            }

            th,
            td {
                padding: 12px 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Países y Ciudades</h1>
            <p class="subtitle">Una presentación sofisticada de datos demográficos con diseño inspirado en las banderas
                nacionales</p>
        </header>

        <main>
            <!-- España -->
            <section class="pais-section">
                <div class="pais-header">
                    <h2 class="pais-nombre">España</h2>
                    <div class="bandera-colores">
                        <div class="color-bandera es-color1"></div>
                        <div class="color-bandera es-color2"></div>
                        <div class="color-bandera es-color1"></div>
                    </div>
                    <div class="pais-info">
                        <span class="ciudades-count">2 ciudades</span>
                    </div>
                </div>

                <div class="tabla-container">
                    <table class="es-table">
                        <thead>
                            <tr>
                                <th>Ciudad</th>
                                <th>Extensión (km²)</th>
                                <th>Habitantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ciudad-destacada">Toledo</td>
                                <td class="numero-dato">100,000 <span class="dato-label">km²</span></td>
                                <td class="numero-dato">70,000 <span class="dato-label">hab.</span></td>
                            </tr>
                            <tr>
                                <td class="ciudad-destacada">Madrid</td>
                                <td class="numero-dato">150,000 <span class="dato-label">km²</span></td>
                                <td class="numero-dato">800,000 <span class="dato-label">hab.</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Alemania -->
            <section class="pais-section">
                <div class="pais-header">
                    <h2 class="pais-nombre">Alemania</h2>
                    <div class="bandera-colores">
                        <div class="color-bandera de-color1"></div>
                        <div class="color-bandera de-color2"></div>
                        <div class="color-bandera de-color3"></div>
                    </div>
                    <div class="pais-info">
                        <span class="ciudades-count">2 ciudades</span>
                    </div>
                </div>

                <div class="tabla-container">
                    <table class="de-table">
                        <thead>
                            <tr>
                                <th>Ciudad</th>
                                <th>Extensión (km²)</th>
                                <th>Habitantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ciudad-destacada">Berlin</td>
                                <td class="numero-dato">5,570 <span class="dato-label">km²</span></td>
                                <td class="numero-dato">7,842 <span class="dato-label">hab.</span></td>
                            </tr>
                            <tr>
                                <td class="ciudad-destacada">Duseldorf</td>
                                <td class="numero-dato">5,470 <span class="dato-label">km²</span></td>
                                <td class="numero-dato">7,962 <span class="dato-label">hab.</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Austria -->
            <section class="pais-section">
                <div class="pais-header">
                    <h2 class="pais-nombre">Austria</h2>
                    <div class="bandera-colores">
                        <div class="color-bandera at-color1"></div>
                        <div class="color-bandera at-color2"></div>
                        <div class="color-bandera at-color1"></div>
                    </div>
                    <div class="pais-info">
                        <span class="ciudades-count">1 ciudad</span>
                    </div>
                </div>

                <div class="tabla-container">
                    <table class="at-table">
                        <thead>
                            <tr>
                                <th>Ciudad</th>
                                <th>Extensión (km²)</th>
                                <th>Habitantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ciudad-destacada">Viena</td>
                                <td class="numero-dato">8,384 <span class="dato-label">km²</span></td>
                                <td class="numero-dato">7,614 <span class="dato-label">hab.</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>

        <footer>
            <p>Diseño sofisticado con inspiración en banderas nacionales | Datos demográficos</p>
        </footer>
    </div>
</body>

</html>