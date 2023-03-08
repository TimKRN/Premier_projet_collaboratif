

{extends file="views/structure.tpl"}


{block name="content"}

{if $strPage == "inscription"}
    <h2 class="text-center mt-3">Créer un compte</h2>
    <p class="text-center">Page de création de compte</p>
    {else}
    <h2 class="text-center mt-3">Modifier un compte</h2>
    <p class="text-center">Page de modification de compte</p>
    {/if}
 
<!-- Formulaire Deviens PetSitter -->
<div>
    <div class="container" id="aaaa">

        <div class="row mt-5">
        {include file="views/error_display.tpl"}
            <div class="offset-md-4 col-md-4 mt-5">
                <form action="index.php?ctrl=user&action={$strPage}" name="inscription" method="post">
                    <div class="mt-5">
                        <input type="hidden" name="id" value="{$objUser->getId()}" />
                        <label for="name" class="form-label" >Nom</label>
                        <input type="text" class="form-control mx-auto" name ="name" id="name" placeholder="Net" value="{if $objUser->getName() != ''}{$objUser->getName()|unescape}{/if}">
                    </div>
                    <div>
                        <label for="firstname" class="form-label" >Prénom</label>
                        <input type="text" class="form-control mx-auto" name="firstname" id="firstname" placeholder="Beans" value="{if $objUser->getFirstName() != ''}{$objUser->getFirstName()|unescape}{/if}">
                    </div>
                    <div>
                        <label for="mail" class="form-label" >Email</label>
                        <input type="email" class="form-control mx-auto" name="mail" id="mail" placeholder="vsCodeWinner@gmail.fr" value="{if $objUser->getMail() != ''}{$objUser->getMail()|unescape}{/if}">
                    </div>
                    <div>
                        <label for="password" class="form-label" >Saisir un mot de passe</label>
                        <input type="password" class="form-control mx-auto" name="password" id ="password" placeholder="********">
                    </div>
                    <div>
                        <label for="confirmpassword" class="form-label" >Confirmer le mot de passe</label>
                        <input type="password" class="form-control mx-auto" name="confirmpassword" id="confirmpassword" placeholder="********">
                    </div>
                    <div>
                        <label for="phone" class="form-label" >Télephone</label>
                        <input type="tel" class="form-control mx-auto" name="phone" id="phone" placeholder="0367300236" value="{if $objUser->getPhone() != ''}{$objUser->getPhone()|unescape}{/if}">
                    </div>
                    <div>
                        <label for="date" class="form-label" >Date de naissance</label>
                        <input type="date" class="form-control mx-auto" name="birthday" id="birthday" value="{if $objUser->getBirthday() != ''}{$objUser->getBirthday()|unescape}{/if}">
                    </div>
                    <div>
                        <label for="address" class="form-label" >Adresse</label>
                        <input type="text" class="form-control mx-auto" name="address" id="address" placeholder="32 Rue de l'Industrie" value="{if $objUser->getAddress() != ''}{$objUser->getAddress()|unescape}{/if}">

                    <div>
                        <label for="cityid" class="form-label" >Ville</label>
						<select id="cityid" name="cityid">
                            <option value=''>--</option>
							{foreach from=$arrCityToDisplay item = objCity}
                                <option {if (in_array($objCity->getId(), $arrSelected))} selected {/if}  value='{$objCity->getId()}'>{$objCity->getCp()} {$objCity->getName()}</option>
                            {/foreach}
						</select>
                    </div>
                    {if isset($smarty.session.user.id) && $smarty.session.user.role == 1}
                    <div>
                    <label for="roleid" class="form-label" >Rôle</label>
                    <select id="roleid" name="roleid">
                        <option value=''>--</option>
                        {foreach from=$arrRoleToDisplay item = objRole}
                            <option {if (in_array($objRole->getId(), $arrSelectedRole))} selected {/if}  value='{$objRole->getId()}'>{$objRole->getId()} {$objRole->getName()}</option>
                        {/foreach}
                    </select>
                    </div>
                    {/if}   
          
                    <div>
                        <div class="mt-3">
                            <label for="forpFile" class="form-label" name="description">Description:</label>

                            <textarea class="form-control" rows="6" name="description">{if $objUser->getDescription() != ''}{$objUser->getDescription()|unescape}{/if}</textarea>


                        </div>
                        <div class="form-check form-check-inline my-2">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" name="personal_data" >
                            <label class="form-check-label" for="inlineCheckbox1" name="personal_data">J’autorise ce site à conserver
                                mes données transmises via ce formulaire</label>
                        </div>
                    </div>
                    <div class="mb-3 mt-2 pb-2 text-center">
                        <input id="bouttonForm" type="submit" value="{if $strPage == 'inscription'}M'inscrire{else}Modifier{/if}"></input>
                    </div>
                </form>
                <div class="mb-5 text-center">
                {if isset($smarty.session.user.id) && $smarty.session.user.id != ''}
                    <p>Pour ajouter une image, <a href="index.php?ctrl=form&action=ajoutImg">Clique ici</a> </p>
                    <p>Accède à ton profil,<a href="index.php?ctrl=user&action=vueProfil&id={$intId}" >Clique ici</a></p>
                {/if}
                </div>
            </div>
        </div>
    </div>
</div>
{/block}