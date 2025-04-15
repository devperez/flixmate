<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau message dans une liste</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="color: #333;">👋 Bonjour {{ $user->name }},</h2>

        <p style="font-size: 16px; color: #555;">
            <strong>{{ $chatMessage->user->name }}</strong> a publié un nouveau message dans la liste <strong>« {{ $chatMessage->list->name }} »</strong>.
        </p>

        <blockquote style="margin: 20px 0; padding: 15px; background-color: #f0f0f0; border-left: 4px solid #4f46e5; font-style: italic;">
            {{ $chatMessage->message }}
        </blockquote>

        <p style="font-size: 14px; color: #888;">
            Posté le {{ $chatMessage->created_at->format('d/m/Y à H:i') }}
        </p>

        <hr style="margin: 30px 0;">

        <p style="font-size: 14px; color: #999;">
            Vous recevez ce message car vous participez à la liste « {{ $chatMessage->list->name }} ».
        </p>

        <p style="text-align: center; margin-top: 20px;">
            <a href="{{ route('lists.show', $chatMessage->list->id) }}" style="background-color: #4f46e5; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                Voir la liste
            </a>
        </p>
    </div>
</body>
</html>
