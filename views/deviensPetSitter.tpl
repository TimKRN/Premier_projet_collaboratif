{extends file="views/structure.tpl"}

{block name="content"}
    <main>
        <div class="container">
            <div class="row text-center">
                <div>
                    <div>
                        <h2 class="px-5 my-2">Fais de la garde animalière</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row text-center">
                <div>
                    <p class="offset-3 col-md-6 my-2 px-4">Pour être choisi comme PetSitter, arrange toi pour ne pas être trop loin de ton
                        contact. Tu auras une note qui te sera attribué à la fin de chaque garde
                        Ca te permettra d'obtenir une moyenne sur ton profil
                    </p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5">
                <div class=" offset-md-2 col-md-4 text-center">
                    <img class="imgDP" src="assets/img/mainPate.jpg" alt="Main homme et patte de chien">
                </div>
                <div class="col-md-4 text-center py-5">
                    <p>Mettre la main à la patte, te permettra de boucler plus facilement tes fins de mois.
                        N'oublie pas que c'est un service pour chacun
                    </p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row my-4">
                <div class=" offset-md-2 col-md-4 text-center py-5">
                    <p>Le meilleur ami des animaux c'est toi, alors nous te faisons confiance pour
                        prendre soin d'eux et rester bienveillant avec tout le monde
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <img class="imgDP" src="assets/img/photoForet.jpg" alt="Une femme et chien dans les bois">
                </div>
            </div>
        </div>
        <div class="container">
            <!-- <hr> -->
        </div>
        <div class="container">
                    <div class="row text-center">
                        <div class="col-md-12 my-4">
                            <p>Pour faire parti de nos PetSitter, <a href="index.php?ctrl=form&action=formNouvPetSitter">Clique ici</a> </p>
                            <p>Pour ajouter ton animal, <a href="index.php?ctrl=form&action=formNouvAnimal">Clique ici</a> </p>
                        </div>
                    </div>
                </div>
        
    </main>
{/block}