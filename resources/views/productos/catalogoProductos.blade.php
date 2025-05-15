@extends('plantilla/layout')

@section('titulo', '- Registro de Productos')

@section('contenido')

    {{-- barra de busqueda --}}
   <div>
        <form class="flex items-center max-w-sm mx-auto  ">   
            <label for="simple-search" class="sr-only">BUSCAR</label>
            <div class="relative w-full">
                <input type="text" id="buscador" class=" border border-green-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar Producto..." required />
            </div>
            {{-- <button type="submit" id="btnFormulario" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search</span>
            </button> --}}
        </form>
   </div>

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <h2 class="font-manrope font-bold text-4xl text-black mb-8 max-lg:text-center">
          Productos
      </h2>

      
      {{--Botones--}}
        <div class='flex justify-between gap-2 mb-8'>

          <button type='button'  id="btn_todos" class=' py-2.5 px-6 text-sm rounded-full border border-solid border-green-500 text-green-600 cursor-pointer font-semibold text-center shadow-xs transition-all duration-100 hover:bg-green-700 hover:text-white'>Todos</button>
          <button type='button'  id="btn_envases" class='py-2.5 px-6 text-sm rounded-full border border-solid border-green-500 text-green-600 cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-green-700 hover:text-white'>Envases</button>
          <button type='button'  id="btn_platos" class='py-2.5 px-6 text-sm rounded-full border border-solid border-green-500 text-green-600 cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-green-700 hover:text-white'>Platos</button>
          <button type='button'  id="btn_vasos"class='py-2.5 px-6 text-sm rounded-full border border-solid border-green-500 text-green-600 cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-green-700 hover:text-white'>Vasos</button>
          <button type='button'  id="btn_cubiertos" class='py-2.5 px-6 text-sm rounded-full border border-solid border-green-500 text-green-600 cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-green-700 hover:text-white'>Cubiertos</button>
          <button type='button'  id="btn_bolsas"class='py-2.5 px-6 text-sm rounded-full border border-solid border-green-500 text-green-600 cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-green-700 hover:text-white'>Bolsas</button>
          <button type='button'  id="btn_papeleria" class='py-2.5 px-6 text-sm rounded-full border border-solid border-green-500 text-green-600 cursor-pointer font-semibold text-center shadow-xs transition-all duration-500 hover:bg-green-700 hover:text-white'>Pepeleria</button>
          

        </div>

        
        {{--FIN--}}

        {{-- Subcategorías --}}
        <div class="flex justify-between gap-2 mb-8">
          <div class="flex items-center">
            <input id="check_almidon" type="checkbox" value=""  class="w-5 h-5 appearance-none border cursor-pointer border-green-500 rounded-md mr-2 hover:border-green-700 hover:bg-green-700 checked:bg-no-repeat checked:bg-center checked:border-green-500 checked:bg-green-700">
            <label for="checkbox-default" class="text-sm font-normal cursor-pointer text-gray-600">Almidón de maíz </label>
          </div>
          <div class="flex items-center">
            <input id="check_bioplastico" type="checkbox" value=""  class="w-5 h-5 appearance-none border cursor-pointer border-green-500 rounded-md mr-2 hover:border-green-700 hover:bg-green-700 checked:bg-no-repeat checked:bg-center checked:border-green-500 checked:bg-green-700">
            <label for="checked-checkbox" class="text-sm font-normal cursor-pointer text-gray-600">Bioplástico</label>
          </div>
          <div class="flex items-center">
            <input id="check_polietileno" type="checkbox" value=""  class="w-5 h-5 appearance-none border cursor-pointer border-green-500 rounded-md mr-2 hover:border-green-700 hover:bg-green-700 checked:bg-no-repeat checked:bg-center checked:border-green-500 checked:bg-green-700">
            <label for="checkbox-default-2" class="text-sm font-normal cursor-pointer text-gray-600">Polietileno biodegradable</label>
          </div>
          <div class="flex items-center">
            <input id="check_organica" type="checkbox" value=""  class="w-5 h-5 appearance-none border cursor-pointer border-green-500 rounded-md mr-2 hover:border-green-700 hover:bg-green-700 checked:bg-no-repeat checked:bg-center checked:border-green-500 checked:bg-green-700">
            <label for="checked-checkbox-2" class="text-sm font-normal cursor-pointer text-gray-600">Materia orgánica</label>
          </div>
          <div class="flex items-center">
            <input id="check_carton" type="checkbox" value=""  class="w-5 h-5 appearance-none border cursor-pointer border-green-500 rounded-md mr-2 hover:border-green-700 hover:bg-green-700 checked:bg-no-repeat checked:bg-center checked:border-green-500 checked:bg-green-700" >
            <label for="checked-checkbox-2" class="text-sm font-normal cursor-pointer text-gray-600">Cartón reciclado</label>
          </div>
          <div class="flex items-center">
            <input id="check_bagazo" type="checkbox" value=""  class="w-5 h-5 appearance-none border cursor-pointer border-green-500 rounded-md mr-2 hover:border-green-700 hover:bg-green-700 checked:bg-no-repeat checked:bg-center checked:border-green-500 checked:bg-green-700" >
            <label for="checked-checkbox-2" class="text-sm font-normal cursor-pointer text-gray-600">Caña de azúcar (bagazo)</label>
          </div>
          <div class="flex items-center">
            <input id="check_pla" type="checkbox" value=""  class="w-5 h-5 appearance-none border cursor-pointer border-green-500 rounded-md mr-2 hover:border-green-700 hover:bg-green-700 checked:bg-no-repeat checked:bg-center checked:border-green-500 checked:bg-green-700">
            <label for="checked-checkbox-2" class="text-sm font-normal cursor-pointer text-gray-600">PLA</label>
          </div>
          <div class="flex items-center">
            <input id="check_bambu" type="checkbox" value=""  class="w-5 h-5 appearance-none border cursor-pointer border-green-500 rounded-md mr-2 hover:border-green-700 hover:bg-green-700 checked:bg-no-repeat checked:bg-center checked:border-green-500 checked:bg-green-700">
            <label for="checked-checkbox-2" class="text-sm font-normal cursor-pointer text-gray-600">Bambú</label>
          </div>
        </div>
{{-- FIN --}}

{{-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
    @foreach ($productos as $producto)
        <a href="productos/{{ $producto->id }}/detalle" class="border rounded-lg p-4 shadow bg-white block hover:shadow-lg transition duration-200">
            <img src="{{ asset($producto->imagen1) }}" alt="{{ $producto->nombre }}" class="w-full h-40 object-cover rounded mb-2">
            <h3 class="text-lg font-bold text-green-800">{{ $producto->nombre }}</h3>
            <p class="text-gray-600 text-sm">{{ $producto->descripcion }}</p>
            <p class="text-green-600 font-semibold mt-2">${{ number_format($producto->precio, 2) }}</p>
        </a>
    @endforeach
</div> --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
    @foreach ($productos as $producto)
        <div class="border rounded-lg p-4 shadow bg-white hover:shadow-lg transition duration-200">
            <a href="productos/{{ $producto->id }}/detalle" class="block">
                <img src="{{ asset($producto->imagen1) }}" alt="{{ $producto->nombre }}" class="w-full h-40 object-cover rounded mb-2">
                <h3 class="text-lg font-bold text-green-800">{{ $producto->nombre }}</h3>
                <p class="text-gray-600 text-sm">{{ $producto->descripcion }}</p>
                <p class="text-green-600 font-semibold mt-2">${{ number_format($producto->precio, 2) }}</p>
            </a>
            
            <form action="{{ route('add') }}" method="post" class="mt-2">
                @csrf
                <input type="hidden" name="id" value="{{ $producto->id }}">
                <button type="submit" class="w-full py-2.5 px-6 text-sm rounded-full border border-solid border-green-500 text-green-600 cursor-pointer font-semibold text-center shadow-xs transition-all duration-100 hover:bg-green-700 hover:text-white flex items-center justify-center gap-2">
                    <svg class="stroke-green-600" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7394 17.875C10.7394 18.6344 10.1062 19.25 9.32511 19.25C8.54402 19.25 7.91083 18.6344 7.91083 17.875M16.3965 17.875C16.3965 18.6344 15.7633 19.25 14.9823 19.25C14.2012 19.25 13.568 18.6344 13.568 17.875M4.1394 5.5L5.46568 12.5908C5.73339 14.0221 5.86724 14.7377 6.37649 15.1605C6.88573 15.5833 7.61377 15.5833 9.06984 15.5833H15.2379C16.6941 15.5833 17.4222 15.5833 17.9314 15.1605C18.4407 14.7376 18.5745 14.0219 18.8421 12.5906L19.3564 9.84059C19.7324 7.82973 19.9203 6.8243 19.3705 6.16215C18.8207 5.5 17.7979 5.5 15.7522 5.5H4.1394ZM4.1394 5.5L3.66797 2.75"
                            stroke="" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                    Agregar al carrito
                </button>
            </form>
        </div>
    @endforeach
</div>



<div class="mt-6">
    {{ $productos->links() }}
</div>
    
    

        


</div>   
<script src="/js/categorias.js"></script> 
<script src="/js/subcategorias.js"></script> 
<script src="/js/buscar.js"></script>
<script src="/js/mouse.js"></script>
<script src="/js/botones.js"></script>
</section>        
   
                                        
    





@endsection