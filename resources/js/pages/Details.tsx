import { useForm } from '@inertiajs/react';
import React, { useState } from 'react'

export default function Details({ device }) {
    const [rawIp, setRawIp] = useState(device.ip.replace(/\./g, ''));
    const [formattedIP, setFormattedIp] = useState(device.ip);

    const { data, setData, post, processing, errors } = useForm({
        ip: device.ip,
        port: device.port || '',
    });

    function handleIpChange(e: React.ChangeEvent<HTMLInputElement>) {
        const input = e.target.value.replace(/\D/g, '');
        setRawIp(input);

        const groups: string[] = [];
        let remaining = input;

        for (let i = 0; i < 4; i++) {
            if (remaining.length === 0) break;

            const part = remaining.slice(0, 2);
            groups.push(part);
            remaining = remaining.slice(part.length);
        }

        const formatted = groups.join('.');
        setFormattedIp(formatted);
        setData('ip', formatted);
    }

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();

        if (!formattedIP || formattedIP.split('.').length !== 4) {
            alert("please enter a complete IP");
            return;
        }

        post(`/relay/${device.id}/details`, {
            onSuccess: () => {
                // <p className='text-green-400'>Device Updated</p>
                alert("Device Updated");
            }
        })
    }


  return (
    <div>
        <h1>Device IP: {device.ip}</h1>

        <form onSubmit={handleSubmit}>
            <div className="mb-4">
                <label htmlFor="ip">Update Device IP:</label>
                <input
                    type="text"
                    name="ip"
                    value={rawIp}
                    className="border border-solid border-blue-500 p-2"
                    onChange={handleIpChange}
                />
                <p className="text-gray-400 mt-1">{formattedIP}</p>
            </div>


            {errors.ip && <div className="text-red-500">{errors.ip}</div>}
            {errors.port && <div className="text-red-500">{errors.port}</div>}

            <div className="button__container flex">
                <button type='submit' className="bg-blue-500 text-white px-4 py-2">Save</button>
                <a href="/relay">
                    <button type='button' className="bg-red-500 text-white px-4 py-2 ml-4">Return to Relays</button>
                </a>
            </div>
        </form>
    </div>
  )
}
