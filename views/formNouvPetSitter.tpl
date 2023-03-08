{extends file="views/structure.tpl"}

{block name="content"}
<main>
    <div>
        <div class="container">
            <div class="row">
            {include file="views/error_display.tpl"}
                <div class="offset-md-4 col-md-4">
                    <form action="index.php?ctrl=form&action=formNouvPetSitter" method="post">
                        <div class="mt-3">
                            <span>Animaux que tu veux garder: </span>
                            <div id="formDPS">
                                {foreach from=$arrPetTypeToDisplay item=objPetType}                            
                                        <div class="form-check form-check-inline">                            
                                        <input class="form-check-input" type="checkbox"   {if (in_array($objPetType->getId(), $arrCheckedPet))}checked{/if} value='{$objPetType->getId()}' id='pt{$objPetType->getId()}' name ="pet_typeid[]">
                                    <label class="form-check-label" for="pt{$objPetType->getId()}">{$objPetType->getKind()}</label>
                                    </div> 
                                {/foreach}
                            </div>
                        </div>
                        <div class="mt-3">
                            <span>Garde que tu souhaites: </span>
                            <div id="formDPS">                                
                                {foreach from=$arrSitterToDisplay item=objSitter}
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" {if (in_array($objSitter->getId(), $arrCheckedSitter))} checked {/if} value='{$objSitter->getId()}' id='sit{$objSitter->getId()}' name ="sitterid[]">
                                        <label class="form-check-label" for="sit{$objSitter->getId()}">{$objSitter->getType()}</label>
                                    </div>
                                {/foreach}                                
                            </div>
                        </div>
                        <div class="mt-3">
                            <span>Ton logement actuel: </span>
                            <div id="formDPS">
                                {foreach from=$arrHomeToDisplay item=objHome} 
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" {if (in_array($objHome->getId(), $arrCheckedHome))} checked {/if} name="homeid" id='home{$objHome->getId()}' value='{$objHome->getId()}'>
                                        <label class="form-check-label" for="home{$objHome->getId()}">{$objHome->getType()}</label>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                        
                        <div>
                            <div class="mt-5">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" name="personal_data">
                                <label class="form-check-label" for="inlineCheckbox1" name="personal_data">J’autorise ce site à conserver
                                    mes données transmises via ce formulaire</label>
                            </div>
                        </div>
                        <div class="mb-5 mt-2 pb-2 text-center">
                            <button id="bouttonForm" type="submit">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

{/block}