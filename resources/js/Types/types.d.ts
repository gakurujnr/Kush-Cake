
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
    address_line1: string| null
    address_line2: string| null
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
    order_item_id: number | null
    order_item?: OrderItem | null
}

export interface Order extends Model{
    user_id: number
    status: 'pending'| 'processing'|'shipped'| 'delivered'| 'cancelled'
    total_amount: number
    customization_value_id: number | null
    order_items: OrderItem[]
    user?: User
    address_id: number |null
    address?: Address | null
    payments?: Payment[] | null
}
export interface OrderItem extends Model{
    order_id: number
    product_id: number
    quantity: number
    price:number
    product?: Product
    order?: Order
    review?: Review | null
}

export interface Payment extends Model
{
    order_id: number
    payment_method: 'credit_card'| 'paypal'| 'mpesa'| 'bank_transfer'|'cash'
    payment_status: 'pending'| 'completed'|'failed'
    payment_amount: number
    payment_date: string | Date | null
    order?: Order

}
 interface Model{
    id: number
    created_at: string | Date,
    updated_at: string | Date | null,
}
