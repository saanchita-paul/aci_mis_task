<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to ACI MIS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="https://www.aci-bd.com/assets/images/favicon.ico" type="image/vnd.microsoft.icon">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #007A33, #a1c5b1);
            font-family: 'Montserrat', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            color: white;
        }

        .logo-animation {
            display: flex;
            font-size: 4rem;
            font-weight: 700;
            gap: 0.5rem;
        }

        .logo-animation span {
            opacity: 0;
            transform: translateY(-50px);
            animation: fadeInUp 0.7s forwards;
        }

        .logo-animation span:nth-child(1) { animation-delay: 0.3s; }
        .logo-animation span:nth-child(2) { animation-delay: 0.6s; }
        .logo-animation span:nth-child(3) { animation-delay: 0.9s; }
        .logo-animation span:nth-child(4) { animation-delay: 1.2s; }
        .logo-animation span:nth-child(5) { animation-delay: 1.5s; }
        .logo-animation span:nth-child(6) { animation-delay: 1.8s; }
        .logo-animation span:nth-child(7) { animation-delay: 2.1s; }
        .logo-animation span:nth-child(8) { animation-delay: 2.4s; }
        .logo-animation span:nth-child(9) { animation-delay: 2.7s; }
        .logo-animation span:nth-child(10) { animation-delay: 3s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        .tagline {
            font-size: 1.2rem;
            margin-top: 20px;
            opacity: 0;
            animation: fadeIn 2s ease-in forwards;
            animation-delay: 3.5s;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .start-btn {
            margin-top: 30px;
            padding: 12px 24px;
            background: white;
            color: rgba(0, 122, 51, 0.8);
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
            opacity: 0;
            animation: fadeIn 2s ease-in forwards;
            animation-delay: 4s;
            text-decoration: none;
        }

        .start-btn:hover {
            background: #f0f0f0;
        }
        .logo-animation {
            display: flex;
            gap: 2rem;
        }

        .word {
            display: flex;
            gap: 0.5rem;
        }

    </style>
</head>
<body>

<div class="logo-animation floating">
    <div class="word">
        <span>A</span>
        <span>C</span>
        <span>I</span>
    </div>
    <div class="word">
        <span>M</span>
        <span>I</span>
        <span>S</span>
    </div>
    <div class="word">
        <span>T</span>
        <span>A</span>
        <span>S</span>
        <span>K</span>
    </div>
</div>

</body>
</html>
