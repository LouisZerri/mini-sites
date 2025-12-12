<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: {{ $agent->couleur_primaire }};
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .info-row {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }
        .value {
            color: #333;
        }
        .message-box {
            background: #f9f9f9;
            padding: 20px;
            border-left: 4px solid {{ $agent->couleur_primaire }};
            margin: 20px 0;
        }
        .footer {
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">📧 Nouveau message</h1>
            <p style="margin: 10px 0 0 0;">Depuis votre mini-site</p>
        </div>
        
        <div class="content">
            <p style="color: #555; margin-bottom: 20px;">
                Bonjour {{ $agent->prenom }},
            </p>
            
            <p style="color: #555;">
                Vous avez reçu un nouveau message via votre mini-site <strong>{{ $agent->nom_complet }}</strong>.
            </p>
            
            <div class="info-row">
                <div class="label">👤 Nom</div>
                <div class="value">{{ $data['nom'] }}</div>
            </div>
            
            <div class="info-row">
                <div class="label">📧 Email</div>
                <div class="value">
                    <a href="mailto:{{ $data['email'] }}" style="color: {{ $agent->couleur_primaire }};">
                        {{ $data['email'] }}
                    </a>
                </div>
            </div>
            
            @if(!empty($data['telephone']))
            <div class="info-row">
                <div class="label">📱 Téléphone</div>
                <div class="value">
                    <a href="tel:{{ $data['telephone'] }}" style="color: {{ $agent->couleur_primaire }};">
                        {{ $data['telephone'] }}
                    </a>
                </div>
            </div>
            @endif
            
            <div style="margin-top: 30px;">
                <div class="label">💬 Message</div>
                <div class="message-box">
                    {{ $data['message'] }}
                </div>
            </div>
            
            <p style="margin-top: 30px; color: #555;">
                💡 <strong>Astuce :</strong> Vous pouvez répondre directement à cet email pour contacter {{ $data['nom'] }}.
            </p>
        </div>
        
        <div class="footer">
            <p style="margin: 0;">
                Ce message a été envoyé depuis votre mini-site <br>
                <strong>{{ $agent->url }}</strong>
            </p>
            <p style="margin: 10px 0 0 0;">
                © {{ date('Y') }} GEST'IMMO - Tous droits réservés
            </p>
        </div>
    </div>
</body>
</html>