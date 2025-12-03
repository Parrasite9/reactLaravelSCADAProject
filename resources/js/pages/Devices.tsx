import React, { useState } from 'react'

export default function Devices({ devices }) {
    console.log(devices);

    const [isOn, setIsOn] = useState(false);
    const [value, setValue] = useState(0);

    function turnOnRelay(id) {
        fetch(`/relay/${id}`)
        .then(response => response.text())
        .then(data => {
            console.log(data);
            location.reload()
        })
    }

    function turnOffRelay(id) {
        fetch(`/relay/${id}`)
        .then(response => response.text())
        .then(data => {
           console.log(data);
           location.reload();
        })
   }

  return (
    <div>
        <h1>Device Page</h1>

        {[].map(device => (
            <div className="flex justify-around mb-4">
                <div className="deviceContainer">
                    <div>DEVICE NAME: ${device.ip}</div>
                </div>

                <div className="powerContainer flex">
                    <div className="onOffButton">
                        {device.value < 1 && (
                            <button className="bg-red-400 px-4 hover:bg-red-200" onClick={() => turnOnRelay(device.id)}>OFF</button>
                        )}

                        {device.value < 0 && (
                            <button className="bg-green-400 px-4 hover:bg-red-200" onClick={() => turnOffRelay(device.id)}>ON</button>
                        )}
                    </div>

                    <div className="detailsButton ml-4">
                        <a href={`/relay/${device.id}/details`}>
                            <button className="bg-gray-700 text-white hover:bg-gray-400 px-4">See Details</button>
                        </a>
                    </div>
                </div>
                <span className="border-solid border-2 border-blue-400 w-full"></span>
            </div>
        ))}
    </div>
  )
}
