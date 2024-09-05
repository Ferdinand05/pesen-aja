<template>
    <button
        data-drawer-target="logo-sidebar"
        data-drawer-toggle="logo-sidebar"
        aria-controls="logo-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
    >
        <span class="sr-only">Open sidebar</span>
        <svg
            class="w-6 h-6"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                clip-rule="evenodd"
                fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
            ></path>
        </svg>
    </button>

    <aside
        id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar"
    >
        <div
            class="h-full px-3 py-4 overflow-y-auto bg-primary dark:bg-gray-800"
        >
            <Link href="/" class="flex items-center ps-2.5 mb-5">
                <span
                    class="self-center text-white text-2xl font-semibold whitespace-nowrap dark:text-white"
                    >PesenAja</span
                >
            </Link>
            <ul class="space-y-2 font-medium">
                <li>
                    <Link
                        :href="route('dashboard')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:text-gray-200 dark:hover:bg-gray-700 group"
                    >
                        <svg
                            class="w-4 h-4 text-gray-800 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 20 20"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7.75 4H19M7.75 4a2.25 2.25 0 0 1-4.5 0m4.5 0a2.25 2.25 0 0 0-4.5 0M1 4h2.25m13.5 6H19m-2.25 0a2.25 2.25 0 0 1-4.5 0m4.5 0a2.25 2.25 0 0 0-4.5 0M1 10h11.25m-4.5 6H19M7.75 16a2.25 2.25 0 0 1-4.5 0m4.5 0a2.25 2.25 0 0 0-4.5 0M1 16h2.25"
                            />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </Link>
                </li>
                <!-- SECTION - MANAGER ONLY -->

                <div v-show="$page.props.auth.user.role == 'Manager'">
                    <li>
                        <Link
                            :href="route('users.index')"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:text-gray-200 dark:hover:bg-gray-700 group"
                        >
                            <svg
                                class="w-4 h-4 text-gray-800 dark:text-white"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g
                                    id="SVGRepo_tracerCarrier"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z"
                                        stroke="#000000"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    ></path>
                                    <path
                                        d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z"
                                        stroke="#000000"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    ></path>
                                </g>
                            </svg>

                            <span class="ms-3">Users</span>
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('categories.index')"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:text-gray-200 dark:hover:bg-gray-700 group"
                        >
                            <svg
                                class="w-4 h-4 text-gray-800 dark:text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 20 16"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 8v1h4V8m4 7H4a1 1 0 0 1-1-1V5h14v9a1 1 0 0 1-1 1ZM2 1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"
                                />
                            </svg>

                            <span class="ms-3">Categories Product</span>
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('products.index')"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:text-gray-200 dark:hover:bg-gray-700 group"
                        >
                            <svg
                                class="w-4 h-4 text-gray-800 dark:text-white"
                                fill="#000000"
                                viewBox="0 0 52 52"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g
                                    id="SVGRepo_tracerCarrier"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="m45.2 19.6a1.6 1.6 0 0 1 1.59 1.45v22.55a4.82 4.82 0 0 1 -4.59 4.8h-32.2a4.82 4.82 0 0 1 -4.8-4.59v-22.61a1.6 1.6 0 0 1 1.45-1.59h38.55zm-12.39 6.67-.11.08-9.16 9.93-4.15-4a1.2 1.2 0 0 0 -1.61-.08l-.1.08-1.68 1.52a1 1 0 0 0 -.09 1.44l.09.1 5.86 5.55a2.47 2.47 0 0 0 1.71.71 2.27 2.27 0 0 0 1.71-.71l4.9-5.16.39-.41.52-.55 5-5.3a1.25 1.25 0 0 0 .11-1.47l-.07-.09-1.72-1.54a1.19 1.19 0 0 0 -1.6-.1zm12.39-22.67a4.81 4.81 0 0 1 4.8 4.8v4.8a1.6 1.6 0 0 1 -1.6 1.6h-44.8a1.6 1.6 0 0 1 -1.6-1.6v-4.8a4.81 4.81 0 0 1 4.8-4.8z"
                                    ></path>
                                </g>
                            </svg>
                            <span class="ms-3">Products</span>
                        </Link>
                    </li>
                </div>

                <!-- SECTION - MANAGER ONLY -->

                <li>
                    <Link
                        :href="route('orders.index')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:text-gray-200 dark:hover:bg-gray-700 group"
                    >
                        <svg
                            class="w-4 h-4 text-gray-800 dark:text-white"
                            viewBox="0 0 1024 1024"
                            fill="#000000"
                            version="1.1"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g
                                id="SVGRepo_tracerCarrier"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M300 462.4h424.8v48H300v-48zM300 673.6H560v48H300v-48z"
                                    fill=""
                                ></path>
                                <path
                                    d="M818.4 981.6H205.6c-12.8 0-24.8-2.4-36.8-7.2-11.2-4.8-21.6-11.2-29.6-20-8.8-8.8-15.2-18.4-20-29.6-4.8-12-7.2-24-7.2-36.8V250.4c0-12.8 2.4-24.8 7.2-36.8 4.8-11.2 11.2-21.6 20-29.6 8.8-8.8 18.4-15.2 29.6-20 12-4.8 24-7.2 36.8-7.2h92.8v47.2H205.6c-25.6 0-47.2 20.8-47.2 47.2v637.6c0 25.6 20.8 47.2 47.2 47.2h612c25.6 0 47.2-20.8 47.2-47.2V250.4c0-25.6-20.8-47.2-47.2-47.2H725.6v-47.2h92.8c12.8 0 24.8 2.4 36.8 7.2 11.2 4.8 21.6 11.2 29.6 20 8.8 8.8 15.2 18.4 20 29.6 4.8 12 7.2 24 7.2 36.8v637.6c0 12.8-2.4 24.8-7.2 36.8-4.8 11.2-11.2 21.6-20 29.6-8.8 8.8-18.4 15.2-29.6 20-12 5.6-24 8-36.8 8z"
                                    fill=""
                                ></path>
                                <path
                                    d="M747.2 297.6H276.8V144c0-32.8 26.4-59.2 59.2-59.2h60.8c21.6-43.2 66.4-71.2 116-71.2 49.6 0 94.4 28 116 71.2h60.8c32.8 0 59.2 26.4 59.2 59.2l-1.6 153.6z m-423.2-47.2h376.8V144c0-6.4-5.6-12-12-12H595.2l-5.6-16c-11.2-32.8-42.4-55.2-77.6-55.2-35.2 0-66.4 22.4-77.6 55.2l-5.6 16H335.2c-6.4 0-12 5.6-12 12v106.4z"
                                    fill=""
                                ></path>
                            </g>
                        </svg>
                        <span class="ms-3">Orders</span>
                    </Link>
                </li>
                <li>
                    <Link
                        :href="route('payments.index')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:text-gray-200 dark:hover:bg-gray-700 group"
                    >
                        <svg
                            class="w-4 h-4 text-gray-800 dark:text-white"
                            width="64px"
                            height="64px"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g
                                id="SVGRepo_tracerCarrier"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></g>
                            <g id="SVGRepo_iconCarrier">
                                <rect
                                    x="3"
                                    y="6"
                                    width="18"
                                    height="13"
                                    rx="2"
                                    stroke="#000000"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></rect>
                                <path
                                    d="M3 10H20.5"
                                    stroke="#000000"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></path>
                                <path
                                    d="M7 15H9"
                                    stroke="#000000"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></path>
                            </g>
                        </svg>
                        <span class="ms-3">Payments</span>
                    </Link>
                </li>
                <li class="border border-gray-200"></li>

                <li>
                    <Link
                        :href="route('orders.history')"
                        as="button"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:text-gray-200 dark:hover:bg-gray-700 group"
                    >
                        <svg
                            class="w-4 h-4 text-gray-800"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g
                                id="SVGRepo_tracerCarrier"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M12 8V12L14.5 14.5"
                                    stroke="#1C274C"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></path>
                                <path
                                    d="M5.60423 5.60423L5.0739 5.0739V5.0739L5.60423 5.60423ZM4.33785 6.87061L3.58786 6.87438C3.58992 7.28564 3.92281 7.61853 4.33408 7.6206L4.33785 6.87061ZM6.87963 7.63339C7.29384 7.63547 7.63131 7.30138 7.63339 6.88717C7.63547 6.47296 7.30138 6.13549 6.88717 6.13341L6.87963 7.63339ZM5.07505 4.32129C5.07296 3.90708 4.7355 3.57298 4.32129 3.57506C3.90708 3.57715 3.57298 3.91462 3.57507 4.32882L5.07505 4.32129ZM3.75 12C3.75 11.5858 3.41421 11.25 3 11.25C2.58579 11.25 2.25 11.5858 2.25 12H3.75ZM16.8755 20.4452C17.2341 20.2378 17.3566 19.779 17.1492 19.4204C16.9418 19.0619 16.483 18.9393 16.1245 19.1468L16.8755 20.4452ZM19.1468 16.1245C18.9393 16.483 19.0619 16.9418 19.4204 17.1492C19.779 17.3566 20.2378 17.2341 20.4452 16.8755L19.1468 16.1245ZM5.14033 5.07126C4.84598 5.36269 4.84361 5.83756 5.13505 6.13191C5.42648 6.42626 5.90134 6.42862 6.19569 6.13719L5.14033 5.07126ZM18.8623 5.13786C15.0421 1.31766 8.86882 1.27898 5.0739 5.0739L6.13456 6.13456C9.33366 2.93545 14.5572 2.95404 17.8017 6.19852L18.8623 5.13786ZM5.0739 5.0739L3.80752 6.34028L4.86818 7.40094L6.13456 6.13456L5.0739 5.0739ZM4.33408 7.6206L6.87963 7.63339L6.88717 6.13341L4.34162 6.12062L4.33408 7.6206ZM5.08784 6.86684L5.07505 4.32129L3.57507 4.32882L3.58786 6.87438L5.08784 6.86684ZM12 3.75C16.5563 3.75 20.25 7.44365 20.25 12H21.75C21.75 6.61522 17.3848 2.25 12 2.25V3.75ZM12 20.25C7.44365 20.25 3.75 16.5563 3.75 12H2.25C2.25 17.3848 6.61522 21.75 12 21.75V20.25ZM16.1245 19.1468C14.9118 19.8483 13.5039 20.25 12 20.25V21.75C13.7747 21.75 15.4407 21.2752 16.8755 20.4452L16.1245 19.1468ZM20.25 12C20.25 13.5039 19.8483 14.9118 19.1468 16.1245L20.4452 16.8755C21.2752 15.4407 21.75 13.7747 21.75 12H20.25ZM6.19569 6.13719C7.68707 4.66059 9.73646 3.75 12 3.75V2.25C9.32542 2.25 6.90113 3.32791 5.14033 5.07126L6.19569 6.13719Z"
                                    fill="#1C274C"
                                ></path>
                            </g>
                        </svg>
                        <span class="ms-3">Order History </span>
                    </Link>
                </li>
                <li class="border border-gray-200"></li>

                <li>
                    <Link
                        :href="route('logout')"
                        as="button"
                        method="post"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:text-gray-200 dark:hover:bg-gray-700 group"
                    >
                        <svg
                            class="w-4 h-4 text-gray-800 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 16 16"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3"
                            />
                        </svg>
                        <span class="ms-3">Logout</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script setup></script>
