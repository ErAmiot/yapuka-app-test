Feature: Inscription d'un utilisateur

Scenario: Inscription réussie avec des données valides
When j'envoie une requête POST sur "/api/auth/register" avec le corps :
"""
    {
      "email": "nouveau@yapuka.dev",
      "username": "Nouveau User",
      "password": "password123"
    }
    """
Then le code de réponse est 201
And la réponse JSON contient la clé "token"

Scenario: Connexion réussie avec des identifiants valides
Given un nouvel utilisateur existe avec l'email "nouveau@yapuka.dev" et le mot de passe "password123"
When j'envoie une requête POST sur "/api/auth/login" avec le corps :
"""
    {
      "email": "nouveau@yapuka.dev",
      "password": "password123"
    }
    """
Then le code de réponse est 200
And la réponse JSON contient la clé "token"