{extends file="views/structure.tpl"}

{block name="content"}

    <div class="container">
        <div class="row text-center my-5">
            <div id="blocFA" class="offset-3 col-md-5">
                <div>
                    <img src="assets/img/icon/iconPS.png" alt="">
                </div>
                <div>
                    <ul class="list-group list-group-flush">
                        {* Note *}
                        <li class="list-group-item text-center">&#x2605; &#x2605; &#x2605; &#x2605; &#x2605;
                        </li>
                        {* User *}
                        <h5>Informations sur l'utilisateur :</h5>
                            <li class="list-group-item">Nom : {$objUser->getName()|unescape}</li>
                            <li class="list-group-item">Prénom : {$objUser->getFirstName()|unescape}</li>
                            <li class="list-group-item">Ville : {$objCity->getName()|unescape}</li>
                            <li class="list-group-item">Date de naissance :
                                {$objUser->getBirthday()|date_format:"d/m/Y"|unescape}</li>
                            <li class="list-group-item">Email : {$objUser->getMail()|unescape}</li>
                            <li class="list-group-item">Numéro de téléphone : {$objUser->getPhone()|unescape}</li>
                            <li class="list-group-item">Description : {$objUser->getDescription()|unescape}</li>
                            {* Role *}
                            <li class="list-group-item">Rôle : {$objRole->getName()|unescape}</li>
                            <br />

                            {* Petsitter *}
                            {if $arrProposeToDisplay != array()}
                                <h5>Services Petsitter:</h5>
                                <li class="list-group-item">Type de logement : {$objHome->getType()}</li>
                                <br />


                                {for $i=0 to count($arrProposeToDisplay)-1}
                                    <li class="list-group-item">Type de garde : {$arrSitterToDisplay[$i]->getType()}</li>
                                    <li class="list-group-item">Type d'animal : {$arrPetTypeSitterToDisplay[$i]->getKind()}</li>
                                    {if $arrProposeToDisplay[$i]->getValid() == 0 && isset($smarty.session.user.id) && $smarty.session.user.role == 3}
                                        <li><a href="index.php?ctrl=user&action=ValidSitter&id={$arrProposeToDisplay[$i]->getId()}" title="Validation proposition">VALIDER LA PROPOSITION DE GARDE</a></li>
                                    {/if}
                                    <br />
                                {/for}
                                <br />
                            {/if}

                            {* Pet(s) *}
                            {if $arrPetToDisplay != array()}
                                <h5>Animaux :</h5>
                                {for $i=0 to count($arrPetToDisplay)-1}
                                    <li class="list-group-item">Nom : {$arrPetToDisplay[$i]->getName()|unescape}</li>
                                    {if $arrPetToDisplay[$i]->getBirthday() != null}
                                        <li class="list-group-item">Date de naissance :
                                            {$arrPetToDisplay[$i]->getBirthday()|date_format:"d/m/Y"}</li>
                                    {/if}
                                    <li class="list-group-item">Type d'animal : {$arrPetTypeToDisplay[$i]->getKind()}</li>
                                    <li class="list-group-item">Sexe : {$arrSexToDisplay[$i]->getType()}</li>
                                    <br />
                                {/for}
                            {/if}

                            {* Image(s) *}
                            {if $arrPictureToDisplay != array()}
                                <h5>Images :</h5>

                                {foreach from=$arrPictureToDisplay item=objPicture}
                                    <img src="assets/imgUsers/{$objPicture->getName()}" class="img-thumbnail"
                                        alt="{$objPicture->getDescription()}" /></a>
                                {/foreach}
                            {/if}

                        </ul>
                    </div>
                </div>
            </div>
        </div>


    {/block}