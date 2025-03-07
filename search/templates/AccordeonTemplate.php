<div x-data="{ isExpanded: false }" class="border border-neutral-300">
    <button id="controlsAccordionItemOne" type="button" class="flex flex-wrap w-full h-[80px] items-center justify-between gap-4 p-4 <?php echo $isEven ? 'bg-neutral-200' : 'bg-neutral-100'; ?> underline-offset-2 hover:bg-surface-alt/75 focus-visible:bg-surface-alt/75 focus-visible:underline focus-visible:outline-hidden" aria-controls="accordionItemOne" x-on:click="isExpanded = ! isExpanded" x-bind:aria-expanded="isExpanded ? 'true' : 'false'">
        <div class="flex-1 min-w-0">
            <p class="text-gray-900 font-[Helvetica Neue] font-semibold text-left truncate"><?=$name?></p>
            <p class="text-gray-800 font-[Helvetica Neue] font-normal text-left truncate"><?=$charge?></p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="isExpanded  ?  'rotate-180'  :  ''">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
        </svg>
    </button>
    <div x-cloak x-show="isExpanded" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
        <div class="p-4 font-[Helvetica Neue] text-gray-800 text-sm sm:text-base text-pretty border-b border-neutral-300">
            <p>Correo electrónico / E-mail</p>
            <p class="font-[Helvetica Neue] text-blue-600 font-semibold"><?=$email?></p>
        </div>
        <div class="p-4 font-[Helvetica Neue] text-gray-800 text-sm sm:text-base text-pretty border-b border-neutral-300">
            <p>Dirección / Address</p>
            <p class="font-[Helvetica Neue] text-gray-900 font-semibold"><?=$address?></p>
        </div>
        <div class="p-4 font-[Helvetica Neue] text-gray-800 text-sm sm:text-base text-pretty">
            <p>Tel.</p>
            <p class="font-[Helvetica Neue] text-gray-900 font-semibold"><?=$phone_number?></p>
        </div>
    </div>
</div>