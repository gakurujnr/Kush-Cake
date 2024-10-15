
 export interface User extends Model{
    name: string
    email: string
    email_verified_at: string | null
    two_factor_confirmed_at: string | null
    user_type: number
    profile_photo_url: string | null
}
 interface Model{
    id: number
    created_at: string | Date,
    updated_at: string | Date | null,
}