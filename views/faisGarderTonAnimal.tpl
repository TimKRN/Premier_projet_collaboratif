{extends file="views/structure.tpl"}

{block name="content"}
    <main>
        <div id="infoPS">
            <div class="container">
                <div class="row text-center">

                    <div class=" offset-md-3 col-md-6 px-5 my-2">
                        <h2>Choisis le PetSitter qui te convient selon tes préférences</h2>
                    </div>
                </div>
            </div>
            <!-- Filtres -->
            <form action="index.php?ctrl=form&action=faisGarderTonAnimal" method="post">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-1">
                            <p>Filtres | </p>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <p>Animaux:</p>
                        </div>
                        {foreach from=$arrPetTypeToDisplay item=objPetType}
                            <div class="form-check form-check-inline col-md-2">
                                <input class="form-check-input" type="checkbox"  {if (in_array($objPetType->getId(), $arrCheckedPet))}checked{/if} value='{$objPetType->getId()}' id='{$objPetType->getId()}' name ="animal[]">
                                <label class="form-check-label" for="{$objPetType->getId()}">{$objPetType->getKind()}</label>
                            </div>
                        {/foreach}
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <p>Type de garde:</p>
                        </div>
                        {foreach from=$arrSitterToDisplay item=objSitter}
                            <div class="form-check form-check-inline col-md-2">
                            <input class="form-check-input" type="checkbox"  {if (in_array($objSitter->getId(), $arrCheckedSitter))} checked {/if} value='{$objSitter->getId()}' id='{$objSitter->getId()}' name ="garde[]">
                            <label class="form-check-label" for="{$objSitter->getId()}">{$objSitter->getType()}</label>
                            </div>
                        {/foreach}
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <p>Code postal: </p>
                        </div>
                        <div class="col-md-1 px-2">
                            <input id="searchbar" onkeyup="search_animal()" type="text" name="cp" placeholder="68000" value="{$intCP}">
                        </div>
                    </div>
                    <div class="mb-5 mt-2 pb-2 text-center">
                        <button id="bouttonForm" type="submit">Rechercher</button>
                    </div>
                </div>
            </form>
            <!-- Profil des PetSitter -->
            
            {*Affichage de la liste des petsitter*}
            {foreach from=$arrResultPetsitter item=$arrDetResultPetsitter}
                {include file="views/resultPetsitter.tpl"}
            {/foreach}

        </div>
    </main>
{/block}