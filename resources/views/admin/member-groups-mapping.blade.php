@extends('admin.layout')

@section('title', 'Member Groups Mapping')
@section('page-title', 'Member Groups Mapping')

@push('styles')
<style>
    .mapping-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .group-section {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .group-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
    }
    .member-item {
        padding: 0.75rem;
        margin: 0.5rem 0;
        background: #f9fafb;
        border-left: 3px solid #3b82f6;
        border-radius: 0.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .member-item:hover {
        background: #f3f4f6;
    }
    .member-info {
        flex: 1;
    }
    .member-actions {
        display: flex;
        gap: 0.5rem;
    }
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .connection-line {
        position: relative;
        margin: 0.5rem 0;
    }
    .connection-line::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 20px;
        height: 2px;
        background: #3b82f6;
    }
    .connection-line::after {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        width: 2px;
        height: 100%;
        background: #3b82f6;
    }
</style>
@endpush

@section('content')
<div class="mb-6">
    <div class="stats-card">
        <h3 class="text-lg font-semibold mb-2">Overview</h3>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <p class="text-sm opacity-90">Total Groups</p>
                <p class="text-2xl font-bold" id="total-groups">0</p>
            </div>
            <div>
                <p class="text-sm opacity-90">Total Members</p>
                <p class="text-2xl font-bold" id="total-members">0</p>
            </div>
            <div>
                <p class="text-sm opacity-90">Total Mappings</p>
                <p class="text-2xl font-bold" id="total-mappings">0</p>
            </div>
        </div>
    </div>
</div>

<div class="mb-4 flex justify-between items-center">
    <h2 class="text-xl font-semibold text-gray-800">Groups and Their Members</h2>
    <button onclick="refreshMapping()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
        Refresh
    </button>
</div>

<div id="mapping-container" class="mapping-container">
    <!-- Mapping will be loaded here -->
    <div class="text-center py-8 text-gray-500">Loading mapping...</div>
</div>

@push('scripts')
<script>
const API_BASE = '/api/mailing-list';

// Load mapping on page load
document.addEventListener('DOMContentLoaded', function() {
    loadMapping();
});

// Load Groups and Members Mapping
async function loadMapping() {
    try {
        // Load groups with members
        const groupsResponse = await fetch(`${API_BASE}/groups`);
        const groupsResult = await groupsResponse.json();
        
        // Load all users
        const usersResponse = await fetch(`${API_BASE}/users`);
        const usersResult = await usersResponse.json();
        
        if (groupsResult.success && usersResult.success) {
            displayMapping(groupsResult.data, usersResult.data);
        }
    } catch (error) {
        console.error('Error loading mapping:', error);
        document.getElementById('mapping-container').innerHTML = 
            '<div class="text-center py-8 text-red-500">Failed to load mapping</div>';
    }
}

// Display the mapping
function displayMapping(groups, allUsers) {
    const container = document.getElementById('mapping-container');
    container.innerHTML = '';
    
    // Calculate stats
    const totalGroups = groups.length;
    const totalMembers = allUsers.length;
    let totalMappings = 0;
    
    groups.forEach(group => {
        totalMappings += group.users ? group.users.length : 0;
    });
    
    document.getElementById('total-groups').textContent = totalGroups;
    document.getElementById('total-members').textContent = totalMembers;
    document.getElementById('total-mappings').textContent = totalMappings;
    
    if (groups.length === 0) {
        container.innerHTML = '<div class="text-center py-8 text-gray-500">No groups found. Create a group first.</div>';
        return;
    }
    
    // Create a map of user IDs to user objects for quick lookup
    const usersMap = {};
    allUsers.forEach(user => {
        usersMap[user.id] = user;
    });
    
    // Display each group with its members
    groups.forEach(group => {
        const groupSection = document.createElement('div');
        groupSection.className = 'group-section';
        
        const members = group.users || [];
        const memberCount = members.length;
        
        groupSection.innerHTML = `
            <div class="group-header">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">${escapeHtml(group.name)}</h3>
                    ${group.description ? `<p class="text-sm text-gray-600 mt-1">${escapeHtml(group.description)}</p>` : ''}
                </div>
                <div class="text-right">
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                        ${memberCount} Member${memberCount !== 1 ? 's' : ''}
                    </span>
                </div>
            </div>
            <div class="members-list">
                ${members.length > 0 ? members.map((member, index) => `
                    <div class="member-item">
                        <div class="member-info">
                            <div class="font-medium text-gray-800">${escapeHtml(member.name || usersMap[member.id]?.name || 'Unknown')}</div>
                            <div class="text-sm text-gray-600">${escapeHtml(member.email || usersMap[member.id]?.email || 'No email')}</div>
                        </div>
                        <div class="member-actions">
                            <button onclick="removeUserFromGroup(${group.id}, ${member.id})" 
                                    class="text-red-600 hover:text-red-800 text-sm">
                                Remove
                            </button>
                        </div>
                    </div>
                `).join('') : '<p class="text-gray-500 text-center py-4">No members in this group</p>'}
            </div>
        `;
        
        container.appendChild(groupSection);
    });
    
    // Show unassigned users if any
    const assignedUserIds = new Set();
    groups.forEach(group => {
        if (group.users) {
            group.users.forEach(user => {
                assignedUserIds.add(user.id);
            });
        }
    });
    
    const unassignedUsers = allUsers.filter(user => !assignedUserIds.has(user.id));
    
    if (unassignedUsers.length > 0) {
        const unassignedSection = document.createElement('div');
        unassignedSection.className = 'group-section';
        unassignedSection.innerHTML = `
            <div class="group-header">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Unassigned Members</h3>
                    <p class="text-sm text-gray-600 mt-1">Members not assigned to any group</p>
                </div>
                <div class="text-right">
                    <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                        ${unassignedUsers.length} Member${unassignedUsers.length !== 1 ? 's' : ''}
                    </span>
                </div>
            </div>
            <div class="members-list">
                ${unassignedUsers.map(user => `
                    <div class="member-item">
                        <div class="member-info">
                            <div class="font-medium text-gray-800">${escapeHtml(user.name)}</div>
                            <div class="text-sm text-gray-600">${escapeHtml(user.email)}</div>
                        </div>
                        <div class="member-actions">
                            <select onchange="addUserToGroup(${user.id}, this.value)" class="text-sm border border-gray-300 rounded px-2 py-1">
                                <option value="">Add to group...</option>
                                ${groups.map(g => `<option value="${g.id}">${escapeHtml(g.name)}</option>`).join('')}
                            </select>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
        container.appendChild(unassignedSection);
    }
}

// Remove user from group
async function removeUserFromGroup(groupId, userId) {
    if (!confirm('Are you sure you want to remove this user from the group?')) {
        return;
    }
    
    try {
        const response = await fetch(`${API_BASE}/groups/${groupId}/remove-user/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            loadMapping();
            alert('User removed from group successfully!');
        } else {
            alert(result.message || 'Failed to remove user from group');
        }
    } catch (error) {
        console.error('Error removing user from group:', error);
        alert('Failed to remove user from group');
    }
}

// Add user to group
async function addUserToGroup(userId, groupId) {
    if (!groupId) return;
    
    try {
        const response = await fetch(`${API_BASE}/groups/${groupId}/add-user/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            loadMapping();
            alert('User added to group successfully!');
        } else {
            alert(result.message || 'Failed to add user to group');
        }
    } catch (error) {
        console.error('Error adding user to group:', error);
        alert('Failed to add user to group');
    }
}

// Refresh mapping
function refreshMapping() {
    loadMapping();
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
@endpush
@endsection

