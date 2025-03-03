<div
    x-data="{
        search: '',
 
        items: [<?= implode(',', array_map(function($item) {
            $properties = [];
            foreach ($item as $key => $value) {
                $properties[] = "$key: '$value'";
            }
            return '{' . implode(', ', $properties) . '}';
        }, $data)); ?>],
 
        get filteredItems() {
            return this.items.filter(
                i => i.name.toLowerCase().includes(this.search.toLowerCase()) ||
                i.charge.toLowerCase().includes(this.search.toLowerCase())
            );
        }
    }"
    class="w-full flex flex-col items-center gap-5"
>
    <div class="relative flex w-full max-w-xs flex-col gap-1 text-gray-800 font-[Helvetica Neue] font-semibold">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50"> 
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
        <input class="form-control rounded-sm border border-neutral-300 bg-neutral-50 py-2 pl-10 pr-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75" 
            type="search" name="search" placeholder="Buscar..."
            x-model="search" x-init="search = ''"/>
    </div>

    <div class="w-full">
        <template x-for="(item, index) in filteredItems" :key="item.id">
            <div x-data="{ isExpanded: false }" class="border border-neutral-300">
                <button id="controlsAccordionItemOne" 
                    type="button" 
                    class="flex flex-wrap w-full h-[80px] items-center justify-between gap-4 p-4  underline-offset-2 hover:bg-surface-alt/75 focus-visible:bg-surface-alt/75 focus-visible:underline focus-visible:outline-hidden" 
                    aria-controls="accordionItemOne" 
                    x-on:click="isExpanded = ! isExpanded" 
                    x-bind:aria-expanded="isExpanded ? 'true' : 'false'"
                    x-bind:class="index % 2 === 0 ? 'bg-neutral-200' : 'bg-neutral-100'"
                >
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-900 font-[Helvetica Neue] font-semibold text-left truncate" x-text="item.name"></p>
                        <p class="text-gray-800 font-[Helvetica Neue] font-normal text-left truncate" x-text="item.charge"></p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="isExpanded  ?  'rotate-180'  :  ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>
                <div x-cloak x-show="isExpanded" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
                    <div class="p-4 font-[Helvetica Neue] text-gray-800 text-sm sm:text-base text-pretty border-b border-neutral-300">
                        <p>Correo electrónico / E-mail</p>
                        <p class="font-[Helvetica Neue] text-blue-600 font-semibold" x-text="item.email"></p>
                    </div>
                    <div class="p-4 font-[Helvetica Neue] text-gray-800 text-sm sm:text-base text-pretty border-b border-neutral-300">
                        <p>Dirección / Address</p>
                        <p class="font-[Helvetica Neue] text-gray-900 font-semibold" x-text="item.address"></p>
                    </div>
                    <div class="p-4 font-[Helvetica Neue] text-gray-800 text-sm sm:text-base text-pretty">
                        <p>Tel.</p>
                        <p class="font-[Helvetica Neue] text-gray-900 font-semibold" x-text="item.phone_number"></p>
                    </div>
                </div>
            </div>
        </template>
    </div>
    
</div>