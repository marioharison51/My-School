<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erreur serveur — {{ config('app.name', 'My School') }}</title>
    <style>
        body { font-family: -apple-system, 'Segoe UI', Roboto, sans-serif; background: #f9fafb; color: #1f2937; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; margin: 0; }
        .card { width: 100%; max-width: 28rem; text-align: center; }
        .brand { display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-bottom: 2rem; font-weight: 700; font-size: 1.125rem; color: #111827; }
        .box { background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border-radius: 0.5rem; padding: 2rem; border: 1px solid #f3f4f6; }
        .icon-wrap { display: inline-flex; align-items: center; justify-content: center; width: 3.5rem; height: 3.5rem; border-radius: 9999px; background: #fef2f2; margin-bottom: 1rem; }
        h1 { font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 0.5rem; }
        p { font-size: 0.875rem; color: #6b7280; margin: 0 0 1.5rem; }
        a.btn { display: inline-flex; align-items: center; padding: 0.625rem 1.25rem; background: #0f766e; color: #fff; font-weight: 500; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none; }
        a.btn:hover { background: #0d9488; }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">{{ config('app.name', 'My School') }}</div>

        <div class="box">
            <div class="icon-wrap">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-8.99 4.5h.01" />
                </svg>
            </div>

            <h1>Erreur serveur</h1>

            <p>Une erreur inattendue s'est produite. L'équipe technique a été notifiée, réessayez dans quelques instants.</p>

            <a href="{{ url('/') }}" class="btn">Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>

