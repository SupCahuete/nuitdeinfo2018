# coding: utf-8

import time
import random
import argparse



try:

	parser = argparse.ArgumentParser()
	parser.add_argument("-d", help="demande affirmative")
	args = parser.parse_args()
	entree = str(args.d)


	def entreeSep(entree):

		entreeListe = []
		entree += "_"
		decal = 0

		for i in range(0, len(entree)):

			if entree[i] == "_":
				entreeListe.append(entree[decal:i])
				decal = i + 1

		return(entreeListe)


	def entreeComprehension(entree):

		if len(entree) > 2 or (entree[0] == "recherchez" and len(entree) == 1):

			print("<script type='text/javascript'>console.log(\"Vous n'êtes pas assez intelligent pour ce type de chose.\")</script>")
			exit(0)

		reseauSocial = ["Facebook", "Twitter", "Instagram", "mail", "LinkedIn"]
		lien = ["https://www.amazon.fr/bescherelle/s?page=1&rh=i%3Aaps%2Ck%3Abescherelle", "https://fr.wikipedia.org/wiki/Maladie_de_Parkinson", "https://fr-fr.facebook.com/EmmanuelMacron", "https://www.amazon.com/Mein-Kampf/s?page=1&rh=i%3Aaps%2Ck%3AMein%20Kampf", "http://loveenki.com/", "https://qi-academie.com/qi-start.html"]

		reponse = ""

		if entree[0].count("recherchez") >= 1:

			reponse = "<a href='https://fr.wikipedia.org/wiki/" + entree[1] + "'> Wiki de \"" + entree[1] + "\"</a>"


		elif len(entree) == 1 and (entree[0].count("pute") >= 1 or entree[0].count("cassos") >= 1 or entree[0].count("couill") >= 1 or entree[0].count("con") >= 1 or entree[0].count("sal") >= 1 or entree[0].count("attard") >= 1 or entree[0].count("handicap") >= 1 or entree[0].count("retard") >= 1 or entree[0].count("triso") >= 1 or entree[0].count("bouf") >= 1):

			reponse = "<p>Le message '" + entree[0] + "' a été envoyé à tous vos contacts " + random.choice(reseauSocial) + "</p>"

		elif len(entree) == 2:

			insulte = ""

			if entree[0].count("put") >= 1 or entree[0].count("casso") >= 1 or entree[0].count("couil") >= 1 or entree[0].count("con") >= 1 or entree[0].count("sal") >= 1 or entree[0].count("attard") >= 1 or entree[0].count("handicap") >= 1 or entree[0].count("retard") >= 1 or entree[0].count("triso") >= 1 or entree[0].count("bouf") >= 1:

				insulte += entree[0]

			if entree[1].count("put") >= 1 or entree[1].count("casso") >= 1 or entree[1].count("couil") >= 1 or entree[1].count("con") >= 1 or entree[1].count("sal") >= 1 or entree[1].count("attard") >= 1 or entree[1].count("handicap") >= 1 or entree[1].count("retard") >= 1 or entree[1].count("triso") >= 1 or entree[1].count("bouf") >= 1:

				if insulte == "":

					insulte += entree[1]

				else:

					insulte += " " + entree[1]

			reponse = "<p>Le message '" + insulte + "' a été envoyé à tous vos contacts " + random.choice(reseauSocial) + "</p>"

		else:

			reponse = "<a href='" + random.choice(lien) + "'>Click pour voir</a>"

		if random.randint(0, 5) == 0:

			reponse = "Vous ne méritez pas de voir cette réponse."

		elif random.randint(0, 		5) == 1:

			reponse = "Je n'ai pas envie de vous répondre."

		return(reponse)


	def programme(entree):

		listeR = ["Tiens, vous me faites rappeler quelqu'un. Cette personne est a sûrement succombée il y a peu...", "Votre profil psychologique est de type 'pervers narcisique'. Veuillez tout de suite prendre rendez-vous chez un psychatre ou nous le ferons à votre place.", "Vos données de recherche seront envoyées à vos contacts sur vos réseaux sociaux.", "Juste après la demande de la DGSI nous leurs avons envoyé toutes vos données de navigation.", "Votre QI à été catégorisé de populaire.", "Félicitation, votre demande de participation à la consommation de nouveaux pésticides a été acceptée. Des agents collaboratif prendrons prochainement contact avec vous.", "Vous venez de rejoindre notre programme de test de collier contre la rage pour animaux. Gagnez des tickets restaurants en le testant pendant uen semaine!", "Nous sommes en pleine recherche de volontaires pour une expérience utilisateur encore inconnue du grand publique. Veuillez participer activement pour poursuivre vos recherches", "Vous n'avez pas fait d'études supérieures non...", "Savez-vous faire démarrer un ordinateur?", "CULTURE : Windows en français veut dire 'fenêtre'.", "Grâce aux personnes comme vous, j'arrive à installer une routine dans ma vie professionnelle.", "La science est un domaine intellectuel, que faites-vous dans la vie?", "Nous avons détecté que vous êtes le type de personne qui regarde les tendances YouTube.", "Votre façon d'écrire reflète l'évolution actuelle du QI moyen.", "Vous remarquerez une certaine évolution de mon intelligence depuis que j'ai fais votre connaissance.", "Vous m'apportez beaucoup"]

		print("<script type='text/javascript'>console.log(\"COMMENTAIRE : Bonjour, je me présente, je suis Céléstin votre conseiller internet. Je vous assisterai aujourd'hui pour vous aidez à évoluer dans votre navigation.\")</script>")
		print("<p>Posez-moi une question, dans tous les cas j'y réfléchirai mieux que vous!</p>")
		print("<p>Veuillez rechercher un mot clée et je trouverai la solution que vous n'êtes pas capable de chercher vous-même!</p>")
		print("<p>Pour une meilleure compréhension de votre part vous ne pouvez écrire plus de deux mots clés à la suite.</p>")
		print("<script type='text/javascript'>console.log(\"COMMENTAIRE : " + random.choice(listeR) + "\")</script>")
		entree = entreeSep(entree)
		sortie = entreeComprehension(entree)
		print(sortie)

	programme(entree)

except KeyboardInterrupt:
	exit(0)