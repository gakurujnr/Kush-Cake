
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
    reviews?: Review[] | null
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

export interface Review extends Model{
    user_id: number
    product_id: number
    rating: number
    comment: string
    user?: User
    product?: Product
}

export interface Order extends Model{
    user_id: number
    status: string
    total_amount: number
    customization_value_id: number | null
    order_items: OrderItem[]
    user?: User
}
export interface OrderItem extends Model{
    order_id: number
    product_id: number
    quantity: number
    price:number
    product?: Product
    order?: Order
}
 interface Model{
    id: number
    created_at: string | Date,
    updated_at: string | Date | null,
}
