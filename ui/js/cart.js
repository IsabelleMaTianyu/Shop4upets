if (!window.cartList) {
    window.cartList = []
}
if (localStorage.getItem('cartList')) {
    window.cartList = JSON.parse(localStorage.getItem('cartList'))
}
$(function () {// 初始化内容

    $(".single-pro-details").on("change", '.cat-num', function () {
        const value = parseInt($(this).val())
        if (value < 1) {
            $(this).val(1)
        }

    });

    function getId() {
        if (window.cartList.length == 0) {
            return 1
        }
        return window.cartList[window.cartList.length - 1].id + 1
    }

    const renderTotalPrice = () => {
        let total = 0
        window.cartList.forEach((item) => {
            total += item.price * item.num
        })
        $("#total-price").text(total)
    }

    function renderCart() {
        if (window.cartList.length == 0) {
            $('.cart-item-wrap').html(`<div class="no-data">Cart is empty</div>`)
            $('#cart-bottom').hide()
            localStorage.setItem('cartList', [])
        } else {
            var cartHtml = ''
            window.cartList.forEach(item => {
                cartHtml += `<div class="cart-item">
        <span class="fas fa-times" data-index="${item.id}"></span>
        <img src="${item.img}" alt="">
        <div class="content">
            <h3 class="cart-product-title">${item.name}</h3>
            <div class="price">£${item.price}/-</div>
            <input type="number"  data-index="${item.id}" class="num-input" value="${item.num}" class="cart-quntity">
        </div>
    </div>`
            });
            $('.cart-item-wrap').html(cartHtml)
            $('#cart-bottom').show()
            localStorage.setItem('cartList', JSON.stringify(window.cartList))
        }

    }
    renderCart()
    renderTotalPrice()
    $('.add-cart-btn').click(function () {
        let price = $('.money').text()
        const name = $('.money-title').text()
        price = parseFloat(price.split('£')[1])
        const num = parseInt($('.cat-num').val())
        const img = $('.single-pro-image-img').attr('src')
        if (!num) {
            alert('Please enter the number of carts added')
            return
        }
        var id = getId()
        const cartObj = {
            id,
            name,
            price,
            num,
            img
        }
        if (!window.cartList.find((item) => item.name == name)) {
            window.cartList.push(cartObj)
        } else {
            window.cartList = window.cartList.map((item) => {
                if (item.name == name) {
                    return {
                        ...item,
                        num: item.num + num
                    }
                } else {
                    return item
                }

            })
        }
        alert('Added successfully')
        renderCart()
        renderTotalPrice()
    })

    $('.add-cart').click(function () {
        const box = $(this).parent().parent().parent()
        const img = box.find('img').attr('src')
        const name = box.find('h3').text()
        let price = box.find('.price').text()
        price = parseFloat(price.split('£')[1])
        const id = getId()
        const cartObj = {
            id,
            name,
            price,
            num: 1,
            img
        }
        if (!window.cartList.find((item) => item.name == name)) {
            window.cartList.push(cartObj)
        } else {
            window.cartList = window.cartList.map((item) => {
                if (item.name == name) {
                    return {
                        ...item,
                        num: item.num + 1
                    }
                }
                return item
            })
        }
        alert('Added successfully')
        renderCart()
        renderTotalPrice()
        return false
    })

    $(".cart-items-container").on("click", '.fa-times', function () {
        const id = $(this).data("index")
        const index = window.cartList.map(item => item.id).indexOf(id)
        if (index > -1) {
            window.cartList.splice(index, 1)
            renderCart()
            renderTotalPrice()
        }
    });

    $(".cart-items-container").on("change", '.num-input', function () {
        const value = parseInt($(this).val())
        if (value > 0) {
            const id = $(this).data("index")
            window.cartList = window.cartList.map((item) => {
                if (item.id == id) {
                    return {
                        ...item,
                        num: parseInt(value)
                    }
                } else {
                    return item
                }
            })
            localStorage.setItem('cartList', JSON.stringify(window.cartList))
            renderTotalPrice()
        } else {
            alert('Quantity cannot be 0')
            $(this).val(1)
        }

    });


});

