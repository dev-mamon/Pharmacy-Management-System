 <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
     <div class="space-y-6">
         <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
             <div>
                 <h1 class="text-2xl font-bold text-gray-900">
                     Badge Categories
                 </h1>
                 <p class="text-sm text-gray-600 mt-1">
                     Manage and organize your badge categories
                 </p>
             </div>

             <div class="flex items-center gap-3 flex-wrap">
                 <button type="button"
                     class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                     <!-- Inline PDF SVG -->
                     <img src="assets/img/icons/pdf.svg" alt="" />
                     <span class="hidden sm:inline">Export PDF</span>
                 </button>
                 <button type="button"
                     class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                     <!-- Inline Excel SVG -->
                     <img src="assets/img/icons/excel.svg" alt="" />
                     <span class="hidden sm:inline">Export Excel</span>
                 </button>
                 <button type="button"
                     class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                         <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             d="M12 5v14M5 12h14" />
                     </svg>
                     <span class="hidden sm:inline">Add Category</span>
                 </button>
             </div>
         </div>

         <!-- Table Card -->
         <div class="bg-white rounded-lg border border-gray-100 shadow-sm">
             <div class="p-4 border-b border-gray-200">
                 <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                     <!-- Left Section: Search + Per Page -->
                     <div class="flex flex-col md:flex-row gap-3 md:items-center flex-1">
                         <!-- Search -->
                         <div class="relative w-full max-w-xs">
                             <i
                                 class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                             <input type="search"
                                 class="w-full h-10 pl-10 pr-3 text-sm rounded-md border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                 placeholder="Search categories..." />
                         </div>

                         <!-- Items Per Page -->
                         <div class="relative">
                             <select
                                 class="h-10 w-24 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                 <option>5</option>
                                 <option selected>10</option>
                                 <option>25</option>
                                 <option>50</option>
                                 <option>100</option>
                             </select>

                             <div
                                 class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                 <i class="fas fa-chevron-down text-xs"></i>
                             </div>
                         </div>
                     </div>

                     <!-- Right Section: Buttons -->
                     <div class="flex gap-2 flex-wrap justify-end">
                         <button
                             class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                             Email
                         </button>
                         <button
                             class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                             Status
                         </button>
                         <button
                             class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                             Created At
                         </button>
                     </div>

                 </div>
             </div>


             <!-- Desktop Table (md+) -->
             <div class="hidden md:block overflow-x-auto no-scrollbar scroll-hint">
                 <table class="w-full">
                     <thead class="bg-gray-50 text-xs font-semibold text-left text-gray-500">
                         <tr class="text-sm font-semibold text-gray-600 tracking-wide uppercase">
                             <th scope="col" class="px-5 py-3">Code</th>
                             <th scope="col" class="px-5 py-3">Name</th>
                             <th scope="col" class="px-5 py-3">Threshold</th>
                             <th scope="col" class="px-5 py-3">Points</th>
                             <th scope="col" class="px-5 py-3">Status</th>
                             <th scope="col" class="px-5 py-3 text-right">Actions</th>
                         </tr>
                     </thead>
                     <tbody class="bg-white divide-y divide-gray-100">
                         <!-- Row 1 -->
                         <tr class="hover:bg-gray-50 transition-colors">
                             <td class="px-5 py-3 text-sm">
                                 <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE001</span>
                             </td>
                             <td class="px-5 py-3 text-sm text-gray-900">
                                 Bronze Level
                             </td>
                             <td class="px-5 py-3 text-sm text-gray-600">100</td>
                             <td class="px-5 py-3">
                                 <span
                                     class="inline-flex items-center gap-1 px-2 py-1 rounded bg-green-50 border border-green-200">
                                     <span class="text-sm font-semibold text-green-700">50</span>
                                     <span class="text-xs text-green-600">XP</span>
                                 </span>
                             </td>
                             <td class="px-5 py-3">
                                 <span
                                     class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                     <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                     Active
                                 </span>
                             </td>
                             <td class="px-5 py-3 text-right">
                                 <div class="flex items-center justify-end gap-2">
                                     <button class="p-2 rounded bg-orange-50 text-orange-600 hover:bg-orange-100">
                                         <i class="far fa-eye"></i>
                                     </button>
                                     <button class="p-2 rounded bg-blue-50 text-blue-600 hover:bg-blue-100">
                                         <i class="far fa-edit"></i>
                                     </button>
                                     <button class="p-2 rounded bg-red-50 text-red-600 hover:bg-red-100">
                                         <i class="far fa-trash-alt"></i>
                                     </button>
                                 </div>
                             </td>
                         </tr>
                     </tbody>
                 </table>
             </div>

             <!-- Mobile Cards (visible < md) -->
             <div class="md:hidden divide-y divide-gray-100">
                 <!-- Card 1 -->
                 <div class="p-4">
                     <div class="flex items-start justify-between gap-3">
                         <div class="flex-1 min-w-0">
                             <div class="flex items-center gap-3">
                                 <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE001</span>
                                 <h3 class="text-sm font-semibold text-gray-900 truncate">
                                     Bronze Level
                                 </h3>
                             </div>
                             <div class="mt-2 text-xs text-gray-600 flex flex-wrap gap-2">
                                 <div class="flex items-center gap-1">
                                     <span class="text-xs font-[14px]">Threshold:</span>
                                     <span>100</span>
                                 </div>
                                 <div class="flex items-center gap-1">
                                     <span class="text-xs font-[14px]">Points:</span>
                                     <span
                                         class="inline-flex items-center gap-1 px-2 py-1 rounded bg-green-50 border border-green-200">
                                         <span class="text-sm font-semibold text-green-700">50</span>
                                         <span class="text-xs text-green-600">XP</span>
                                     </span>
                                 </div>
                                 <div class="flex items-center gap-1">
                                     <span class="text-xs font-[14px]">Status:</span>
                                     <span
                                         class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                         <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                         Active
                                     </span>
                                 </div>
                             </div>
                         </div>

                         <div class="flex items-start gap-2">
                             <button
                                 class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                 aria-label="View Bronze Level">
                                 <i class="far fa-eye" aria-hidden="true"></i>
                             </button>
                             <button
                                 class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                 aria-label="Edit Bronze Level">
                                 <i class="far fa-edit" aria-hidden="true"></i>
                             </button>
                             <button
                                 class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                 aria-label="Delete Bronze Level">
                                 <i class="far fa-trash-alt" aria-hidden="true"></i>
                             </button>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200">
                 <div class="text-sm text-gray-700">
                     Showing 1 to 2 of 2 entries
                 </div>
                 <div class="flex items-center gap-2">
                     <button
                         class="px-3 py-1.5 text-xs font-[14px] text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50"
                         aria-label="Previous page">
                         Previous
                     </button>
                     <button class="px-3 py-1.5 text-xs font-[14px] text-white bg-orange-500 rounded"
                         aria-current="page" aria-label="Page 1">
                         1
                     </button>
                     <button
                         class="px-3 py-1.5 text-xs font-[14px] text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50"
                         aria-label="Next page">
                         Next
                     </button>
                 </div>
             </div>
         </div>
     </div>
 </main>
