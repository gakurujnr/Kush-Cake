
 export interface User extends Model{
    name: string
    email: string
    email_verified_at: string | null
    two_factor_confirmed_at: string | null
    user_type: number
    profile_photo_url: string | null,
     addresses: Address[] | null
}

export interface Category extends Model{
    name: string
    description: string | null
    slug: string
}

export interface Product extends Model{
    name: string
    description: string | null
    price: number
    category_id: number
    stock: number
    category: Category
    slug: string
    image?: Image | null
}
export interface Image extends Model{
    image_url: string
    product_id: number
    url?: string
    // product: Product
}

export interface Customization extends Model{
    name: string
    description: string | null
}

export interface Address extends Model{
    user_id: number
    address_line_1: string| null
    address_line_2: string| null
    city: string| null
    postal_code: string| null
    country: string| null
    state: string| null
}
 interface Model{
    id: number
    created_at: string | Date,
    updated_at: string | Date | null,
}
