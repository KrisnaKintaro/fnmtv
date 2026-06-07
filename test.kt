private fun loadUsers() {
        lifecycleScope.launch {
            try {
                val response = ApiClient.getApiService(this@AdminUserCrudActivity).getAllUsers()
                if (response.isSuccessful) {
                    val users = response.body()?.data ?: emptyList()
                    adapter.updateData(users)
                }
                // ...
