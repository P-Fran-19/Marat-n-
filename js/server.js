import express from 'express'; // ambiente 
import cors from 'cors'; // libreria para lebantar el servidor 

const app = express(); // creamos una instancia de express

// configuración del servidor 
app.use(express.urlencoded({ extended: false })); // para que el servidor entienda los datos que le llegan
app.use(express.json()); // para que el servidor entienda los datos en formato JSON
app.use(cors()); // para que el servidor pueda recibir peticiones de otros dominios

import { MercadoPagoConfig , Preference} from 'mercadopago';

// Agregar tus credenciales de Mercado Pago
const client = new MercadoPagoConfig({ accessToken: 'NUESTRO_ACCESS_TOKEN' }); // ---------CAMBIAR POR EL TOKEN DE MERCADO PAGO ----

//Routes Ping
app.get('/ping', (req, rs) => {
rs.json({ message: 'pong' });
});

// Routes para crear una preferencia de pago
app.post("/create-preference", (req, res)=>{

const preference = new Preference(client);
    preference.create({
        body: {
            items: [
            {
                title: "Entrada fiesta",
                quantity: 1, // cantidad de entradas
                unit_price: 8000, // precio de cada entrada
            }
        ],
    }
})
        .then((data)=>{ // obtenermos el id de la preferencia
            console.log(data);
            res.status(200).json({
                preference_id: data.id,
                preference_url: data.init_point, // url para redirigir al usuario a Mercado Pago
            })
        })
        .catch(() => {res.status(500).json({ error: "Error al crear la preferencia de pago" });
    });

});

app.listen(8080, () => {
    console.log('Servidor corriendo en http://localhost:8080');
});
// minuto 5 https://www.youtube.com/watch?v=0MLQRkclZGw