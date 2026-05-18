<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($users as $user)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-96 flex flex-col hover:shadow-md transition-shadow duration-200 relative">
        <!-- Decorative Background - Large User Silhouette -->
        <div class="absolute bottom-16 right-0 -mr-8 opacity-5 pointer-events-none">
            <svg class="w-36 h-36 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
        </div>
        
        <!-- User Header - Compact -->
        <div class="flex flex-col items-center p-4 border-b border-gray-100 flex-shrink-0 relative z-10">
            <!-- Profile Picture or Avatar -->
            <div class="w-16 h-16 rounded-lg overflow-hidden mb-3 shadow-sm border border-gray-200">
                @if($user->getProfilePictureUrl())
                    <img src="{{ $user->getProfilePictureUrl() }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                @else
                    @php $avatar = $user->getDefaultAvatar(); @endphp
                    <div class="w-full h-full {{ $avatar['color'] }} flex items-center justify-center text-white font-semibold text-lg">
                        {{ $avatar['initials'] }}
                    </div>
                @endif
            </div>
            
            <div class="text-center">
                <h3 class="text-base font-semibold text-gray-900 truncate max-w-32">{{ $user->name }}</h3>
                <p class="text-xs text-gray-500">ID: {{ $user->id }}</p>
            </div>
            
            <!-- Status Badge -->
            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium mt-2 border {{ $user->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                <div class="w-1.5 h-1.5 {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-1.5"></div>
                {{ $user->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        
        <!-- User Content - Flexible Height -->
        <div class="flex-1 flex flex-col p-4 min-h-0 relative z-10">
            <!-- Email - Fixed Height -->
            <div class="flex items-center text-gray-600 mb-3 h-6">
                <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
                <span class="text-xs truncate">{{ $user->email }}</span>
            </div>
            
            <!-- Department - Fixed Height -->
            <div class="flex items-center text-gray-600 mb-3 h-6">
                <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="text-xs truncate">{{ $user->department }}</span>
            </div>
            
            <!-- Role Badge - Fixed Height -->
            <div class="flex items-center justify-center mb-4 h-8">
                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium border
                    @if($user->role === 'admin') bg-purple-50 text-purple-700 border-purple-200 @else bg-blue-50 text-blue-700 border-blue-200 @endif">
                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            
            <!-- Actions - Fixed at Bottom -->
            <div class="mt-auto flex flex-col space-y-2 pt-2 border-t border-gray-100 flex-shrink-0 relative z-10">
                <button @click="selectedUser = {
                    ...{{ $user->toJson() }},
                    profile_picture_url: '{{ $user->getProfilePictureUrl() }}',
                    avatar_initials: '{{ $user->getDefaultAvatar()['initials'] }}',
                    avatar_color: '{{ $user->getDefaultAvatar()['color'] }}'
                }; viewModal = true" class="w-full inline-flex items-center justify-center px-3 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-150 text-xs font-medium">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View
                </button>
                
                <div class="flex space-x-2">
                    <button @click="selectedUser = {
                        ...{{ $user->toJson() }},
                        profile_picture_url: '{{ $user->getProfilePictureUrl() }}',
                        avatar_initials: '{{ $user->getDefaultAvatar()['initials'] }}',
                        avatar_color: '{{ $user->getDefaultAvatar()['color'] }}'
                    }; editModal = true" class="flex-1 inline-flex items-center justify-center px-2 py-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-150 text-xs font-medium">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </button>
                    
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('users.toggle-active', $user) }}" style="display:contents">
                        @csrf
                        <button type="submit"
                                class="flex-1 inline-flex items-center justify-center px-2 py-2 rounded-lg transition-colors duration-150 text-xs font-medium {{ $user->is_active ? 'text-yellow-600 hover:bg-yellow-50' : 'text-green-600 hover:bg-green-50' }}">
                            @if($user->is_active)
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                Deactivate
                            @else
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Activate
                            @endif
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <!-- Modern Empty State -->
    <div class="col-span-full text-center py-16 bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No users found</h3>
        <p class="text-gray-500 mb-6 text-sm">Create your first user account to get started with the system.</p>
        <button @click="resetForm(); createModal = true" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-900 to-yellow-600 text-white font-medium rounded-lg hover:from-amber-800 hover:to-yellow-500 transition-all duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add User
        </button>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($users->hasPages())
<div class="mt-8 flex justify-center">
    {{ $users->links() }}
</div>
@endif
