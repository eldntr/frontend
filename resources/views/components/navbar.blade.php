<nav class="bg-white dark:bg-gray-800 antialiased">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4">
      <div class="flex items-center justify-between">
  
        <div class="flex items-center lg:space-x-2">
            <a class="text-teal-700 text-3xl no-underline hover:no-underline font-extrabold" href="/">AnuPedia</a>
        </div>

        <div class="flex items-center lg:space-x-2">
          {{-- Search Button --}}
          <button id="searchButton" data-collapse-toggle="search-content" type="button" class="inline-flex items-center search-icon cursor-pointer rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            <svg class="fill-current pointer-events-none text-grey-darkest w-4 h-4 inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
            </svg>
          </button>
          {{-- MyCart Button --}}
          <a href="{{ route('cart.index') }}" title="myCart">
            <button id="myCartDropdownButton1" type="button" class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
              <span class="sr-only">
                Cart
              </span>
              <svg class="w-5 h-5 lg:me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
              </svg> 
              <span class="hidden sm:flex">Cart</span>          
            </button>
          </a>
          
          @auth
            <button id="userDropdownButton1" data-dropdown-toggle="userDropdown1" type="button" class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
              <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
              </svg>              
              Account
              <svg class="w-4 h-4 text-gray-900 dark:text-white ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
              </svg> 
            </button>
    
            {{-- Account Dropdown --}}
            <div id="userDropdown1" class="hidden z-10 w-56 divide-y divide-gray-100 overflow-hidden overflow-y-auto rounded-lg bg-white antialiased shadow dark:divide-gray-600 dark:bg-gray-700">
              <ul class="p-2 text-start text-sm font-medium text-gray-900 dark:text-white">
                <li><a href="/users" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"> My Account </a></li>
                <li><a href="{{ route('wishlist.index') }}" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"> 
                  Wishlist 
                  </a>
                </li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                      @csrf
                      <button type="submit" class=" text-white inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm bg-teal-600 hover:bg-teal-700 dark:hover:bg-gray-600"> 
                        Sign Out 
                      </button>
                    </form>
                </li>
              </ul>
            </div>
          @else
            <div class="items-center flex-inline">
              <a
                  href="{{ route('login') }}"
                  class="py-2.5 px-2.5 mx-2 no-underline hover:no-underline text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                  role="button"
                >
                  Login
                </a>
    
                <a
                  href="{{ route('register') }}"
                  class="py-2.5 px-2.5 no-underline hover:no-underline text-sm font-medium text-white focus:outline-none bg-teal-700 rounded-lg border border-gray-200 hover:bg-teal-800 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-teal-600 dark:text-white dark:border-gray-600 dark:hover:bg-teal-700"
                  role="button"
                >
                  Register
                </a>
            </div>
          @endauth
          {{-- Account Button --}}
          

          {{-- Menu Button For Phone --}}
          {{-- <button type="button" data-collapse-toggle="ecommerce-navbar-menu-1" aria-controls="ecommerce-navbar-menu-1" aria-expanded="false" class="inline-flex lg:hidden items-center justify-center hover:bg-gray-100 rounded-md dark:hover:bg-gray-700 p-2 text-gray-900 dark:text-white">
            <span class="sr-only">
              Open Menu
            </span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
            </svg>                
          </button> --}}
        </div>
      </div>
  
      {{-- Menu Dropdown for Phone
      <div id="ecommerce-navbar-menu-1" class="bg-gray-50 dark:bg-gray-700 dark:border-gray-600 border border-gray-200 rounded-lg py-3 hidden px-4 mt-4">
        <ul class="text-gray-900 dark:text-white text-sm font-medium space-y-3">
          <li>
            <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Home</a>
          </li>
          <li>
            <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Wishlist</a>
          </li>
          
        </ul>
      </div> --}}

      {{-- Search Input --}}
    <form action="{{ route('product.search') }}" method="GET" id="search-form">
        <div class="relative w-full hidden bg-white shadow-xl" id="search-content">
            <div class="container mx-auto py-4 text-black">
                <input id="search" type="search" name="search" placeholder="Search..." autofocus="autofocus" class="w-full rounded-lg text-teal-800 transition focus:outline-none focus:border-transparent p-2 appearance-none leading-normal text-xl lg:text-2xl" required>
            </div>
        </div>
    </form>

    </div>


  </nav>